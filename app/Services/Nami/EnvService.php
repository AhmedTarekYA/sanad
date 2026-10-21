<?php

namespace App\Services\Nami;

use App\Services\MainService;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;
use msztorc\LaravelEnv\Env;

class EnvService extends MainService
{

    public function __construct(Env $env)
    {
        $this->env = $env;
    }

    public function getindex()
    {

        $data = $this->env->getVariables();
        return $data;
    }

    public function storeKey($key, $value)
    {
        try {
            $result = $this->env->setValue($key, $value);
            return $result;
        } catch (\Exception $e) {
            return false;
        }
    }


    public function deleteVariable($key)
    {
        return $this->env->deleteVariable($key);
    }
}
