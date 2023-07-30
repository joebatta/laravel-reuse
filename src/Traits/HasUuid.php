<?php

namespace Joebatta\Reuse\Traits;

use Ramsey\Uuid\Uuid;

trait HasUuid
{
    public static function bootHasUuid()
    {
        static::creating(function ($model) {
            if(empty($model->uuid) || !Uuid::isValid($model->uuid)) {
                $model->uuid = Uuid::uuid4();
            }
        });
    }
}
