<?php

namespace Baiss\ViewGenerator\Commands\Services;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

// class ControllerGeneratorService implements GeneratorContrat {
class EditGeneratorService {

    /**
     * Cette methode permet la génération du fichier edit du module en se basant sur le model dans ./stubs/views/edit.stub
     *
     * @param String $model
     * @return void
     */
    public function generate(String $model){
        $index_stub = file_get_contents(__DIR__ . "/../stubs/views/edit.stub");

        // Ici on défini comment seront changées les différentes variables présents dans le fichier stub de la vue
        // Dans ledit fichier, les variables sont précédées d'un "#"
        $replace = [
            "#layout" => config('allGeneratorConfig.layout'),
            "#section" => config('allGeneratorConfig.section'),

            "#reset_text" => config('allGeneratorConfig.edit_cancel_text'),
            "#submit_text" => config('allGeneratorConfig.edit_submit_text'),
            "#titre" => config('allGeneratorConfig.create_title') ?? ($model . 's Liste'),

            "#update_route" => Str::lower($model) . 's.update\', $' . Str::lower($model) . '->id',
            "#include" => Str::lower($model) . 's.partials.form',
        ];

        // if (!file_exists(base_path() . '/resources/views/' . Str::lower($model) . 's')) {
        //     mkdir(base_path() . '/resources/views/' . Str::lower($model) . 's', 0777, true);
        // }

        $index_stub = str_replace(array_keys($replace), array_values($replace), $index_stub);
        File::put(base_path() . '/resources/views/' . Str::lower($model) . 's/' . 'edit.blade.php', $index_stub);
    }

}

