<?php
namespace App\Http\Controllers;

use App\Http\Controllers\CrudController;
use App\Repositories\NAME_MODELRepository;


class NAME_MODELController extends CrudController
{
  
    public function __construct(NAME_MODELRepository $repo)
    {
        parent::__construct($repo, 'NAME_TABLE');
    }    
}