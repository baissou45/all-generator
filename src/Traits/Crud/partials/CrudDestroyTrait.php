<?php

namespace Baiss\ViewGenerator\Traits\Crud\partials;

trait CrudDestroyTrait{

    public function destroy($id){
        $model_name = str_replace('Controller', '', last(explode('\\', get_called_class())));
        // $this->authorize('access', strtolower($model_name) . "s.delete");

        $model = 'App\Models\\' . $model_name;
        $data = $model::find($id);

        $data->delete();
        return back()->with('success', __('The :resource was deleted!', ['resource' => __('Colonne')]));
    }

}