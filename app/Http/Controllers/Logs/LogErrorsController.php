<?php

namespace App\Http\Controllers\Logs;

use App\Http\Controllers\CrudController;
use App\Repositories\LogErrorsRepository;


class LogErrorsController extends CrudController
{
    public function __construct(LogErrorsRepository $repo)
    {
        parent::__construct($repo, 'logs');
        $this->viewIndex = "pages.logs.errors";
        $this->viewShow = "pages.logs.error-show";
        $this->fieldFilterText = "message";
    }    

}
