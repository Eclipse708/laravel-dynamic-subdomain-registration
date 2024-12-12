<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class CreateSubdomain extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'create:subdomain';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command creates a new subdomain';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        try {
            $cpanelService = new CpanelService();

            $subdomain = $this->ask('Enter subdomain name');

            $result = $cpanelService->createSubdomain($subdomain);

            print_r($result);

        } catch (\Exception $e) {

        }
    }
}
