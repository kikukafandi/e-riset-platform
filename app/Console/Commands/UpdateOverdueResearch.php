<?php

namespace App\Console\Commands;

use App\Models\DokumenPermohonan;
use Illuminate\Console\Command;
use Carbon\Carbon;

class UpdateOverdueResearch extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'research:update-overdue';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update research status for overdue research and ban researchers';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting overdue research update...');

        $overdueResearch = DokumenPermohonan::where('status', 'diterima')
            ->where('status_penelitian', '!=', 'selesai')
            ->where('deadline_penelitian', '<', Carbon::now())
            ->where('dapat_perijinan_lagi', true) // Only update those not already banned
            ->get();

        $updatedCount = 0;

        foreach ($overdueResearch as $research) {
            $research->status_penelitian = 'terlambat';
            $research->dapat_perijinan_lagi = false;
            $research->save();
            
            $updatedCount++;
            
            $this->line("Updated research ID {$research->id} - {$research->judul_riset}");
        }

        $this->info("Updated {$updatedCount} overdue research records.");
        $this->info('Overdue research update completed.');

        return Command::SUCCESS;
    }
}