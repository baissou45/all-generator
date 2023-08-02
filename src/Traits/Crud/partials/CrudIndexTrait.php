<?php

namespace Baiss\ViewGenerator\Traits\Crud\partials;

use Illuminate\Support\Str;

trait CrudIndexTrait{

    public function index(){
        $model_name = str_replace('Controller', '', last(explode('\\', get_called_class())));
        // $this->authorize('access', $model_name . "s.index");
        $model = 'App\Models\\' . $model_name;

        return view(strtolower($model_name) . "s.index")->with([
            Str::lower($model_name) . 's' => $model::latest()->paginate(10),
            'model' => $model_name
        ]);
    }

}