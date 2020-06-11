<?php

namespace Pyramid\Console;

use Pyramid\Pyramid;
use Illuminate\Console\Command;

class VersionCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'pyramid:version';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Display pyramid version';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $this->info(
            'Pyramid ' . Pyramid::version()
        );
    }
}
