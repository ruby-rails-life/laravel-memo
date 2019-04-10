<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Imports\ProjectImport;

class ImportExcelCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:excel {file}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import Excel File From Storage app.';

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
        $this->output->title('Starting import');
        $file = $this->argument('file');
        (new ProjectImport)->withOutput($this->output)->import($file);
        $this->output->success('Import successful');
    }
}
