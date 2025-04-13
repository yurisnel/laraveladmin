<?php

namespace App\Console\Commands\ybr;

use Illuminate\Console\Command;



/**
 * Class Crud
 * @package App\Console\Commands\ybr
 */


class GenMigrationCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ybr:gen-migrations';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generated migrations form datebase';

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

        $this->gencode();
    }


    public function gencode()
    {
        error_reporting(E_ALL ^ E_NOTICE);


        $result = DataBaseInfo::getTables();

        foreach ($result as $tablaName) {
            $objTable = new Table($tablaName);
            if ($this->create($this->getFilePath($tablaName), $objTable->createMigration()))
                $this->info("Migration of $tablaName Created");
        }
    }

    protected function getFilePath($tbname)
    {
        $path = $this->laravel->basePath() . "/database/migrations/";
        return $path . "/" . date('Y_m_d_His') . '_create_' . $tbname . '_table.php';
    }


    private function create($filepath, $text)
    {
        if (!file_exists($filepath)) {
            $this->write($filepath, $text);
            return true;
        }
        $this->info("File is exist!!!");
        return false;
    }

    private function write($filepath, $text)
    {
        // Asegurarse primero de que el archivo existe y puede escribirse sobre el.
        $file = fopen($filepath, 'w+');
        if ($file) {
            // Escribir $cont a nuestro arcivo abierto.
            if (fwrite($file, $text) === FALSE) {
                throw new Exception("Filewrite");
            }
        } else {
            throw new Exception("Fileopen");
        }
        fclose($file);
    }
}
