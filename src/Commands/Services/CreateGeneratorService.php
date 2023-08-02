<?php

namespace Baiss\ViewGenerator\Commands\Services;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

// class ControllerGeneratorService implements GeneratorContrat {
class CreateGeneratorService {

    /**
     * Cette methode permet la génération du fichier create du module en se basant sur le model dans ./stubs/views/create.stub
     *
     * @param String $model
     * @return void
     */
    public function generate(String $model){
        $index_stub = file_get_contents(__DIR__ . "/../stubs/views/create.stub");

        // Ici on défini comment seront changées les différentes variables présents dans le fichier stub de la vu
        // Dans ledit fichier, les variables sont précédées d'un "#"
        $replace = [
            "#layout" => config('allGeneratorConfig.layout'),
            "#section" => config('allGeneratorConfig.section'),

            "#reset_text" => config('allGeneratorConfig.cancel_reset_text'),
            "#submit_text" => config('allGeneratorConfig.create_submit_text'),
            "#titre" => config('allGeneratorConfig.create_title') ?? ($model . 's Liste'),

            "#store_route" => Str::lower($model) . 's.store',
            "#include" => Str::lower($model) . 's.partials.form'
        ];

        $index_stub = str_replace(array_keys($replace), array_values($replace), $index_stub);
        File::put(base_path() . '/resources/views/' . Str::lower($model) . 's/' . 'create.blade.php', $index_stub);
    }

}

