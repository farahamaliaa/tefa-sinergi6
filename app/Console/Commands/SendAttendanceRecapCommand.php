<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use App\Models\Classroom;
use App\Models\AttendanceRule;
use App\Services\AttendanceRecapService;
use App\Services\WhatsAppService;
use Illuminate\Console\Command;

class SendAttendanceRecapCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:send-attendance-recap 
                            {--classroom= : Specific classroom UUID to send recap for}
                            {--force : Force send even if time check fails}
                            {--dry-run : Preview message without sending}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send attendance recap to WhatsApp groups for each classroom';

    private AttendanceRecapService $recapService;
    private WhatsAppService $whatsAppService;

    public function __construct(
        AttendanceRecapService $recapService,
        WhatsAppService $whatsAppService
    ) {
        parent::__construct();
        $this->recapService = $recapService;
        $this->whatsAppService = $whatsAppService;
    }

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $today = Carbon::now();
        $day = strtolower($today->format('l'));
        
        $this->info("Running attendance recap for: {$today->format('l, j F Y')}");

        // Check if recap is enabled
        if (!config('whatsapp.recap.enabled', true)) {
            $this->warn('Attendance recap is disabled in config.');
            return self::SUCCESS;
        }

        // Check if today is a holiday (from attendance rules)
        $rule = AttendanceRule::where('day', $day)
            ->where('role', 'student')
            ->first();

        if ($rule && $rule->is_holiday && !$this->option('force')) {
            $this->info("Today is a holiday. Skipping recap.");
            return self::SUCCESS;
        }

        // Check if it's past checkin_end time (unless forced)
        if ($rule && !$this->option('force')) {
            $checkinEnd = Carbon::parse($rule->checkin_end);
            if ($today->lt($checkinEnd)) {
                $this->warn("Current time ({$today->format('H:i')}) is before checkin_end ({$checkinEnd->format('H:i')}). Use --force to override.");
                return self::SUCCESS;
            }
        }

        // Get classrooms with WhatsApp groups configured
        $query = Classroom::whereNotNull('whatsapp_group_id')
            ->whereRelation('schoolYear', 'active', 1);

        if ($classroomId = $this->option('classroom')) {
            $query->where('id', $classroomId);
        }

        $classrooms = $query->get();

        if ($classrooms->isEmpty()) {
            $this->warn('No classrooms with WhatsApp groups found.');
            return self::SUCCESS;
        }

        $this->info("Found {$classrooms->count()} classroom(s) with WhatsApp groups.");
        $this->newLine();

        $successCount = 0;
        $failCount = 0;

        foreach ($classrooms as $classroom) {
            $this->line("Processing: {$classroom->name}");

            // Generate recap
            $recap = $this->recapService->getRecapByClassroom($classroom->id, $today);
            
            if (empty($recap)) {
                $this->warn("No data found for this classroom.");
                continue;
            }

            // Format message
            $message = $this->recapService->formatWhatsAppMessage($recap);

            if ($this->option('dry-run')) {
                $this->info("[DRY RUN] Message preview:");
                $this->line($message);
                $this->newLine();
                continue;
            }

            // Send to WhatsApp
            $result = $this->whatsAppService->sendToGroup(
                $classroom->whatsapp_group_id,
                $message
            );

            if ($result['success']) {
                $this->info("Message sent successfully.");
                $successCount++;
            } else {
                $this->error("Failed: {$result['message']}");
                $failCount++;
            }
        }

        $this->newLine();
        $this->info("Summary: {$successCount} success, {$failCount} failed.");

        return $failCount > 0 ? self::FAILURE : self::SUCCESS;
    }
}
