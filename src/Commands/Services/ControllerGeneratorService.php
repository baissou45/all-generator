<?php

namespace Baiss\ViewGenerator\Commands\Services;

use Illuminate\Support\Facades\File;

class ControllerGeneratorService {

    /**
     * Cette methode permet la génération du controller en se basant sur le model dans ./stubs/controller.stub
     * Elle permet aussi de de faire hériter le controller ainsi généré d'un trait lui donnant par défaut la logique nécéssaire pour un crud
     *
     * @param String $model
     * @return void
     */
    public function generate(String $model){
        $controller_stub = file_get_contents(__DIR__ . "/../stubs/controller.stub");

        $replace = [
            "#controller" => $model . 'Controller',
        ];

        $generated_controller = str_replace(array_keys($replace), array_values($replace), $controller_stub);
        File::put(app_path() . '/Http/Controllers/' . $model . 'Controller.php', $generated_controller);
    }

}

