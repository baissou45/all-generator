<?php

namespace Baiss\ViewGenerator\Traits\Crud\partials;

use Illuminate\Support\Str;

trait CrudEditTrait{

    public function edit($id){
        $model_name = str_replace('Controller', '', last(explode('\\', get_called_class())));
        // $this->authorize('access', strtolower($model_name) . "s.update");

        $model = 'App\Models\\' . $model_name;

        return view(strtolower($model_name) . "s.edit")->with(
            Str::lower($model_name), $model::find($id)
        );
    }

}