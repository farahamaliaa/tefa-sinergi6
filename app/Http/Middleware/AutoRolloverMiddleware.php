<?php

namespace App\Http\Middleware;

use App\Services\SchoolYearRolloverService;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AutoRolloverMiddleware
{
    private SchoolYearRolloverService $rolloverService;

    public function __construct(SchoolYearRolloverService $rolloverService)
    {
        $this->rolloverService = $rolloverService;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $this->rolloverService->handleRollover();
        
        return $next($request);
    }
}
