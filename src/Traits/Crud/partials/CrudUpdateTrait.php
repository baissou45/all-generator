<?php

namespace Baiss\ViewGenerator\Traits\Crud\partials;

use Illuminate\Http\Request;

trait CrudUpdateTrait{

    public function update(Request $request, $id){
        $model_name = str_replace('Controller', '', last(explode('\\', get_called_class())));
        // $this->authorize('access', strtolower($model_name) . "s.update");

        $model = 'App\Models\\' . $model_name;
        $request->validate($this::validation(true));

        $data = $model::find($id);
        $req_data = $request->except(['_token']);

        // if (request()->hasFile(request()->file_name)) {
        //     if(is_array(request()[request()->file_name])){
        //         $saved_file = [];
        //         foreach (request()[request()->file_name] as $key => $file) {
        //             array_push($saved_file, save_file(request()->file_save_path, $file));
        //         }
        //         $req_data[request()->file_name] = json_encode($saved_file);
        //     } else {
        //         $req_data[request()->file_name] = save_file(request()->file_save_path, request()[request()->file_name]);
        //     }
        // }

        $data->update($req_data);
        if (request()->crud_update_redirect) {
            return redirect()->route('crud.index', ['model' => $model_name])->with('success', __('The :resource was created!', ['resource' => __($model_name)]));
        } else {
            return redirect()->route(strtolower($model_name) . 's.index')->with('success', __('The :resource was created!', ['resource' => __($model_name)]));
        }
    }


}