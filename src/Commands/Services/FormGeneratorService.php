<?php

namespace Baiss\ViewGenerator\Commands\Services;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

// class ControllerGeneratorService implements GeneratorContrat {
class FormGeneratorService {

    /**
     * Undocumented function
     *
     * @param String $model
     * @param Collection $table
     * @return void
     */
    public function generate(String $model, Collection $table){
        $form = '';

        foreach ($table as $key => $colonne) {
            if ($colonne[0] != 'id' && $colonne[0] != 'created_at' && $colonne[0] != 'updated_at') {
                if (Str::contains($colonne[0], '_id')) {
                    $input_stub = file_get_contents(__DIR__ . "/../stubs/form/select.stub");
                } else {
                    $input_stub = file_get_contents(__DIR__ . "/../stubs/form/input.stub");
                }

                // Ici on défini comment seront changées les différentes variables présents dans le fichier stub de la vue
                // Dans ledit fichier, les variables sont précédées d'un "#"
                $replace = [
                    "#libelle" => Str::contains($colonne[0], '_id') ? str_replace('_id', '', $colonne[0]) : $colonne[0],
                    "#name" => $colonne[0],
                    "#type" => $this->getType($colonne[1]),
                    "#value" => "$" . Str::lower($model) . '?->' . $colonne[0],
                ];

                $input_stub = str_replace(array_keys($replace), array_values($replace), $input_stub);
                $form .= ($key != 0 ? "\n\n" : '') . $input_stub;
            }
        }

        File::put(base_path() . '/resources/views/' . Str::lower($model) . 's/partials/' . 'form.blade.php', $form);
    }

    /**
     * Cette methode permet de retourner le type de l'input en fonction du type dans la base données
     *
     * @param String $colonne
     * @return void
     */
    private function getType(String $colonne){
        switch ($colonne) {
            case 'datetime':
                return "datetime-local";
                break;

            case 'timestamp':
                return "datetime-local";
                break;

            case 'time':
                return "time";
                break;

            case 'bigint':
                return "number";
                break;

            case 'float':
                return "number";
                break;

            case 'string':
                return "text";
                break;

            default:
                return "text";
                break;
        }
    }

}

