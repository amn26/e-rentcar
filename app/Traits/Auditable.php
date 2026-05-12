<?php

namespace App\Traits;

trait Auditable
{
    protected static function bootAuditable()
    {
        static::creating(function ($model) {
            if (auth()->check()) {
                $model->CreatedBy = auth()->user()->name;
                $model->CreatedDate = now();
            }
        });

        static::updating(function ($model) {
            if (auth()->check()) {
                $model->LastUpdatedBy = auth()->user()->name;
                $model->LastUpdatedDate = now();
            }
        });
    }
}
