<?php

namespace Pyramid\Console;

use Illuminate\Console\Command;

class PublishCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'pyramid:publish'

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Publish all of the Pyramid resources';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $this->call('vendor:publish', [
            '--tag' => 'pyramid-config',
            '--force' => $this->option('force'),
        ]);
    }
}
