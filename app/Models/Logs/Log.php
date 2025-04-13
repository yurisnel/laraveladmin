<?php

namespace App\Models\Logs;

use App\Helpers\Helper;
use App\Traits\ModelCommon;
use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    use ModelCommon;

    public $appends = [
        'creator_full_name', 'to_string',
    ];

    protected $casts = [
        'created_at' => 'datetime:d-m-Y H:i',
    ];

    public function __toString()
    {
        return sprintf("el log ");
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->created_user_id)) {
                $user = auth()->user();
                $model->created_user_id = $user ? $user->id : 0;
            }
            if (empty($model->ip)) {
                $model->ip = request()->ip();
            }
            if (empty($model->browser)) {
                $model->browser = Helper::getBrowser();
            }
            if (empty($model->so)) {
                $model->so = Helper::getSO();
            }
        });
    }
}
