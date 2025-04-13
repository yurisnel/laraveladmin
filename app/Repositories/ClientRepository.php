<?php

namespace App\Repositories;


use App\Models\Client;
use Illuminate\Container\Container as Application;
use Illuminate\Validation\Rule;
/*use Malahierba\ChileRut\ChileRut;
use Malahierba\ChileRut\Rules\ValidChileanRut;*/

class ClientRepository extends BaseRepository
{

    public function __construct(Application $app)
    {
        parent::__construct($app, Client::class);
    }

    public function rules($id): array
    {
        if (!$id) {
            $rules = [
                //'rut' => ['string', 'nullable', 'unique:clients', new ValidChileanRut(new ChileRut)],
                'dni' => ['string', 'nullable', 'unique:clients'],
                'business_name' => 'required|string|max:50|unique:clients',
                'email' => 'required|email|max:255|unique:clients',
                'telephone' => 'required|string|min:9|max:12',
                'address' => 'required|string|max:500',
                'giro' => 'required|string|max:255',
                'contact_name' => 'required|string|max:255',
                'contact_telephone' => 'required|string|min:9|max:12',
                'description' => 'nullable',
                'type' => 'nullable|type|between:0,1',
                'state' => 'numeric|between:0,1',
            ];
        } else {
            $rules = [
                //'rut' => ['nullable', 'string', Rule::unique('clients')->ignore($id), new ValidChileanRut(new ChileRut)],
                'dni' => ['nullable', 'string', Rule::unique('clients')->ignore($id)],
                'business_name' => ['nullable', 'string', 'max:50', Rule::unique('clients')->ignore($id)],
                'email' => ['nullable', 'email', 'max:50', Rule::unique('clients')->ignore($id)],
                'telephone' => 'nullable|string|min:9|max:12',
                'description' => 'nullable',
                'giro' => 'nullable|string|max:255',
                'contact_name' => 'nullable|string|max:255',
                'contact_telephone' => 'nullable|string|min:9|max:12',
                'address' => 'nullable|string|max:500',
                'type' => 'nullable|type|between:0,1',
                'state' => 'numeric|between:0,1',
            ];
        }
        return  $rules;
    }

    public function messages(): array
    {
        return [
            'dni' => __('validation.value_invalid'),
            'dni.unique' => __('validation.unique_value'),
        ];
    }

    public function authDestroy($role): bool
    {
        return true;
    }
}
