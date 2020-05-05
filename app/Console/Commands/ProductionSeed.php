<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ProductionSeed extends Command
{
    /**
     * The Seeder instance.
     *
     * @var \DatabaseSeeder
     */
    private $seeder;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'production:seed';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Seeds application in production environment';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->seeder = new \DatabaseSeeder();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->runSeed();
        $this->info('Database seeding in production mode completed successfully.');

        return true;
    }

    /**
     * Runs the registered seeds
     *
     * @return void
     */
    private function runSeed()
    {
        $this->seeder->call([
            \AdminsTableSeeder::class,
            \ProvincesTableSeeder::class,
            \CitiesTableSeeder::class
        ]);
    }
}
