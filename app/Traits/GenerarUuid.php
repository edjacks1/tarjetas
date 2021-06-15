<?php

namespace App\Traits;
use Webpatser\Uuid\Uuid;

trait GenerarUuid
{

    public static function boot(){
        parent::boot();

        self::creating(function ($model) {
            $model->uuid = (string) Uuid::generate(4);
        });
    }

    public function getRouteKeyName(){
        return 'uuid';
    }
}
