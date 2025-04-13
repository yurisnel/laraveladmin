<?php

namespace App\Repositories;


use App\Models\Logs\LogEvent;
use Illuminate\Container\Container as Application;


class LogEventsRepository extends BaseRepository
{

    public function __construct(Application $app)
    {
        parent::__construct($app, LogEvent::class);
    }

    public function rules($id): array
    {
        return  [];
    }    
}
