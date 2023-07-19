<?php

namespace App\Repositories;

use App\Traits\{ EloquentTrait, StorageTrait, DatatableTrait };

abstract class BaseRepository
{
    use EloquentTrait, StorageTrait, DatatableTrait;

    public function __call(string $name, array $arguments) {
        return call_user_func_array([$this->model, $name], $arguments);
    }
}