<?php

namespace App\Console\Commands;

use App\Jobs\ResetSlotJob;
use Illuminate\Console\Command;

class ResetSlotCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reset:slots';

    protected $description = 'Reset slots';

    public function handle()
    {
        ResetSlotJob::dispatch()->delay(now()->endOfWeek()); // Lên lịch reset vào cuối tuần
        $this->info('Resetting slots scheduled!');
    }
}
