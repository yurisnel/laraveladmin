<?php

namespace App\Repositories;


use App\Models\NAME_MODEL;
use Illuminate\Container\Container as Application;
use Illuminate\Validation\Rule;


class NAME_MODELRepository extends BaseRepository
{

    public function __construct(Application $app)
    {
        parent::__construct($app, NAME_MODEL::class);
    }

    public function rules($id): array
    {
        if (!$id) {
            $rules = [                
                'name' => 'required|string|max:50'
            ];
        } else {
            $rules = [               
                'name' => ['string', 'max:50']
            ];
        }
        return  $rules;
    }
}