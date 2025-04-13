<?php

namespace App\Http\Controllers;

use App\Http\Controllers\CrudController;
use App\Repositories\ClientRepository;



class ClientController extends CrudController
{
    protected $fieldFilterText = "business_name";
    protected $fieldOrderFieldDefault = "business_name";
    protected $fieldOrderDirDefault = "ASC";
    
    public function __construct(ClientRepository $repo)
    {
        parent::__construct($repo, 'clients');
    }
}
