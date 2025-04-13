<?php

namespace App\Repositories;

use App\Models\Logs\LogError;
use Illuminate\Container\Container as Application;


class LogErrorsRepository extends BaseRepository
{

    public function __construct(Application $app)
    {
        parent::__construct($app, LogError::class);
    }

    public function rules($id): array
    {
        return  [];
    }
   
}
