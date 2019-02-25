<?php

namespace Memed\Console\Commands;

use Illuminate\Console\Command;

use Memed\Services\CrudMedicalServices;
use Memed\Services\MedicalServices;
use Memed\Services\MedicamentosServices;

class ExecuteCrawler extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:crawler {char}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Comando para executar o crawler';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    protected $crudMedicalServices;

    public function __construct( CrudMedicalServices $crudMedicalServices)
    {
        parent::__construct();

        $this->crudMedicalServices = $crudMedicalServices;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
       $resutl = $this->crudMedicalServices->store($this->argument('char'));
        $this->info($resutl);
    }
}
