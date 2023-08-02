<?php

namespace Baiss\ViewGenerator\Traits\Crud\partials;

use Illuminate\Support\Str;

trait CrudCreateTrait{

    public function create(){
        $model_name = str_replace('Controller', '', last(explode('\\', get_called_class())));
        $this->authorize('access', strtolower($model_name) . "s.create");

        return view(strtolower($model_name) . "s.create")->with([
            Str::lower($model_name) => null
        ]);
    }

}