<?php

namespace App\Console\Commands\ybr;

use Illuminate\Console\Command;


/**
 * Class GenCrudCommand
 * @package App\Console\Commands\ybr
 *
 *
 */


class GenCrudCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ybr:gen-crud {tablename} {--force}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generated crud form datebase';

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
        $tablaName = $this->argument('tablename');
        $force = $this->option('force');

        // $this->info($this->laravel->basePath());
        $this->gencode($tablaName, $force);
    }


    public function gencode($tablaName, $force)
    {
        error_reporting(E_ALL ^ E_NOTICE);

        $pathModels = $this->laravel->basePath() . "/app/Models";
        $pathRepositories = $this->laravel->basePath() . "/app/Repositories";
        $pathCtrl = $this->laravel->basePath() . "/app/Http/Controllers";
        $pathRoutes = $this->laravel->basePath() . "/routes";
        $pathSeeders = $this->laravel->basePath() . "/database/seeders";
        $pathViews = $this->laravel->basePath() . "/resources/views/pages/" . $tablaName;
        
       
        $objTable = new Table($tablaName);

        $this->create($pathModels,  $objTable->getNameModel() . '.php', $objTable->createModel(), $force);
        $this->create($pathRepositories , $objTable->getNameModel() . 'Repository.php', $objTable->createRepository(), $force);
        $this->create($pathCtrl, $objTable->getNameModel() . 'Controller.php', $objTable->createController(), $force);
        $this->create($pathRoutes, $objTable->getNameTable() . '.php', $objTable->createRoutes(), $force);
        $this->create($pathSeeders, $objTable->getNameModel() . 'Seeder.php', $objTable->createSeeder(), $force);

        $this->create($pathViews, 'create.blade.php', $objTable->createCreate(), $force);
        $this->create($pathViews, 'edit.blade.php', $objTable->createEdit(), $force);
        $this->create($pathViews, 'form.blade.php', $objTable->createForm(), $force);
        $this->create($pathViews, 'show.blade.php', $objTable->createShow(), $force);
        $this->create($pathViews ,'index.blade.php', $objTable->createIndex(), $force);

        
    }

    private function create($path, $fileName, $text, $force)
    {
        if (!file_exists($path)){
            mkdir($path, 0777);
        }       

        $filepath = $path . "/" .$fileName;
        
        if (!file_exists($filepath) || $force) {
            $this->write($filepath, $text);
            $this->info("File Created: $filepath");
            return true;
        }
        $this->error("File exist: $filepath ");
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
