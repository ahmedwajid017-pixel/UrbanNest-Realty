<?php

namespace App\Console\Commands;

use App\Models\Property;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class SecurityCheckCommand extends Command
{
    protected $signature = 'security:check';

    protected $description = 'Check important UrbanNest Realty security configurations';

    public function handle(): int
    {
        $checksPassed = 0;
        $checksFailed = 0;

        $this->info('UrbanNest Realty Security Check');
        $this->newLine();

        // Check role middleware
        $middleware = app('router')->getMiddleware();

        $this->check(
            isset($middleware['role']),
            'Role middleware is registered',
            $checksPassed,
            $checksFailed
        );

        // Check Property policy
        $this->check(
            Gate::getPolicyFor(Property::class) !== null,
            'Property policy is registered',
            $checksPassed,
            $checksFailed
        );

        // Check default roles in database
        try {
            $roles = DB::table('roles')
                ->whereIn('name', ['Owner', 'Agent', 'Staff'])
                ->pluck('name')
                ->all();

            $this->check(
                count($roles) === 3,
                'Owner, Agent, and Staff roles exist',
                $checksPassed,
                $checksFailed
            );
        } catch (\Throwable $e) {
            $this->check(
                false,
                'Roles table and default roles exist',
                $checksPassed,
                $checksFailed
            );
        }

        // Check public storage link
        $this->check(
            file_exists(public_path('storage')),
            'Public storage link exists',
            $checksPassed,
            $checksFailed
        );

        $this->newLine();
        $this->info("Passed: {$checksPassed}");
        $this->error("Failed: {$checksFailed}");

        return $checksFailed === 0
            ? self::SUCCESS
            : self::FAILURE;
    }

    private function check(
        bool $passed,
        string $message,
        int &$checksPassed,
        int &$checksFailed
    ): void {
        if ($passed) {
            $this->info("[PASS] {$message}");
            $checksPassed++;
        } else {
            $this->error("[FAIL] {$message}");
            $checksFailed++;
        }
    }
}