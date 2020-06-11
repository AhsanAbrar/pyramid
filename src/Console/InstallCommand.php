<?php

namespace Pyramid\Console;

use Illuminate\Console\Command;

class InstallCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'pyramid:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install all of the Pyramid resources';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $this->comment('Publishing Pyramid Assets / Resources...');

        $this->callSilent('pyramid:publish');

        $this->info('Pyramid scaffolding installed successfully.');
    }
}
