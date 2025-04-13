<?php

namespace App\Repositories;

use Illuminate\Container\Container as Application;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use \Illuminate\Http\Response;
use Illuminate\Support\Facades\Password;
use App\Models\Access\User;
use App\Notifications\RequestActiveUser;
use App\Exceptions\ExceptionCustom;
use App\Jobs\QueuedSendNotificationsJob;
/*use Malahierba\ChileRut\Rules\ValidChileanRut;
use Malahierba\ChileRut\ChileRut;*/


class UserRepository extends BaseRepository
{

    public function __construct(Application $app)
    {
        parent::__construct($app, User::class);
    }

    public function rules($id): array
    {
        if (!$id) {
            $rules = [
                //'rut' => ['string', 'nullable', 'unique:users', new ValidChileanRut(new ChileRut)],
                'dni' => ['string', 'nullable', 'unique:users'],
                'email' => 'email|max:255|unique:users',
                'password' => 'required|min:6',
                'name' => 'required|string|max:50',
                'fathername' => 'required|max:50',
                'mothername' => 'required|max:50',
                'state' => 'numeric|between:0,1',
                'role_id' => 'numeric|exists:roles,id',
            ];
        } else {
            $rules = [
                //'rut' => ['string', Rule::unique('users')->ignore($id), 'nullable', new ValidChileanRut(new ChileRut)],
                'dni' => ['string', Rule::unique('users')->ignore($id), 'nullable'],
                'email' => ['email', 'max:255', Rule::unique('users')->ignore($id)],
                'password' => 'min:6',
                'name' => 'string|max:50',
                'fathername' => 'max:50',
                'mothername' => 'max:50',
                'state' => 'numeric|between:0,1',
                'role_id' => 'numeric|exists:roles,id',
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

    public function authDestroy($route): bool
    {
        return true;
    }

    public function create(array $attributes)
    {
        //$attributes['password'] = fake()->password(6, 6);
        $attributes['password'] = "123456";
        $user = parent::create($attributes);
        if (!empty($attributes['client'])) {
            $this->assignUserToClient($user, $attributes['client']);
        }
        return $user;
    }

    public function assignUserToClient($user, $clientId)
    {
        // forzar la eliminacion de aquellas instancias que habian sido eliminadas logicamente para evitar el errror de duplicidad de keys
        /*ClientUser:: //onlyTrashed()
            where('user_id', $user->id)
            ->where('client_id', $clientId)
            ->forceDelete();

        return $user->clients()->attach($clientId, [
            'created_user_id' => auth()->user()->id
        ]);*/
    }

    public function update(array $attributes, $id)
    {
        // no se edita password por esta funcion
        unset($attributes['password']);

        // el mismo usuario no puede cambiar su estado activo/desactivo ni su rol
        if (Auth::user()->id == $id) {
            unset($attributes['state']);
            unset($attributes['role_id']);
        }

        // a un usuario superadmin, solo puede modificarlo otro usuario superadmin
        $user = $this->findByIdOrFail($id);
        if ($user->hasRoleName('SuperAdmin') && !Auth::user()->hasRoleName('SuperAdmin')) {
            throw new ExceptionCustom(__('messages.not_access'), Response::HTTP_FORBIDDEN);
        }
        return parent::update($attributes, $id);
    }

    public function resetPassword(int $userId)
    {
        $user = $this->findByIdOrFail($userId);
        if ($user->state == 0 || !$user->role_id) {
            throw new ExceptionCustom(__('messages.user_inactive'), Response::HTTP_FORBIDDEN);
        }

        // si no es superAdmin, solo puede realizar la operacion en los usuarios que ha creado el o su admin
        /*if (auth()->user()->role_id != 1 && (auth()->user()->id != $user->created_user_id && auth()->user()->created_user_id != $user->created_user_id)) {
            throw new ExceptionCustom(__('messages.not_access'), Response::HTTP_FORBIDDEN);
        }*/

        $status = Password::sendResetLink(['email' => $user->email]);

        if ($status == Password::RESET_LINK_SENT)
            return true;
        else
            throw new ExceptionCustom(__($status), Response::HTTP_BAD_REQUEST);
    }

    public function requestUserActivation(int $userId)
    {
        $user = $this->findByIdOrFail($userId);
        //$adminCreator = $this->where('id', $user->created_user_id)->where('state', 1)->first();
        QueuedSendNotificationsJob::dispatchIfEnableWork($this->getSuperAdmins(), new RequestActiveUser($user));
        return true;
    }

    public function getSuperAdmins()
    {
        return $this->where('role_id', 1)->where('state', 1)->get();
    }
}
