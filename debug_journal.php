
$activeSchoolYear = \App\Models\SchoolYear::where('active', true)->first();

echo "Active School Year: " . ($activeSchoolYear ? 'FOUND' : 'NULL') . "\n";
if ($activeSchoolYear) {
    echo "ID: " . $activeSchoolYear->id . "\n";
    echo "School Year: " . $activeSchoolYear->school_year . "\n";
    echo "Created At: " . $activeSchoolYear->created_at . "\n";
    echo "Created At (Timestamp): " . $activeSchoolYear->created_at->timestamp . "\n";
    $startDate = $activeSchoolYear->created_at;
} else {
    $startDate = now()->startOfYear();
    echo "Fallback triggered.\n";
}

echo "Start Date used: " . $startDate->format('Y-m-d H:i:s') . "\n";
echo "Now: " . now()->format('Y-m-d H:i:s') . "\n";
echo "End Date (now - 1 day): " . now()->subDay()->format('Y-m-d H:i:s') . "\n";

if ($startDate->lte(now()->subDay())) {
    echo "Loop WOULD run.\n";
} else {
    echo "Loop would NOT run.\n";
}
