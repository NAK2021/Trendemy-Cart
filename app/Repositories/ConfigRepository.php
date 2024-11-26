<?php

namespace App\Repositories;

use App\Models\Config;
use App\Repositories\Interfaces\ConfigRepositoryInterface;



class ConfigRepository implements ConfigRepositoryInterface
{
    private $model;
    public function __construct()
    {
        $this->model = Config::class;
    }

    public function getByName($name)
    {
        return $this->model::where('name', $name)->first();
    }
}
