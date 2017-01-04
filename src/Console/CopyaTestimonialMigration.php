<?php

namespace CopyaPost\Console;

use Illuminate\Console\Command;
use Symfony\Component\Process\Process;
use Exception;

class CopyaTestimonialMigration extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'copya-testimonial:migration';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a migration for Copya Testimonial.';

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
     * @return mixed
     */
    public function handle()
    {
        if ($this->makeMigration()) {
            $this->info('Migration successfully created!');

            return;
        }
        $this->error('[InvalidArgumentException]');
        $this->error('Migration already exists.');

        return;
    }

    protected function makeMigration()
    {
        $copya_testimonial_setup = __DIR__ . "/stubs/migration/CopyaTestimonialMigration.php";
        $copyaTestimonialMigrationFile = base_path("/database/migrations") . "/" . date('Y_m_d_His') . "_copya_testimonial_migration.php";


        try {
            if (!class_exists('CopyaTestimonialMigration')) {
                if (!file_exists($copyaTestimonialMigrationFile) && $fs = fopen($copyaTestimonialMigrationFile, 'x')) {
                    fwrite($fs, file_get_contents($copya_testimonial_setup));
                    fclose($fs);
                }
            }
        } catch (Exception $e) {
            return false;
        }

        return true;
    }

}
