<?php

namespace App\Trait;

use Illuminate\Support\Str;

trait HashSlug
{
    protected static function bootHashSlug()
    {
        static::creating(function ($model) {
            $model->slug = Str::slug($model->slug ?? $model->title);
        });

        static::updating(function ($model) {
            if ($model->isDirty('slug')) {
                $model->slug = Str::slug($model->slug);
            }

            if ($model->isDirty('title') && !$model->isDirty('slug')) {
                $model->slug = Str::slug($model->title);
            }
        });
    }
}
