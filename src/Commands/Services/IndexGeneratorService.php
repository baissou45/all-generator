<?php

namespace Baiss\ViewGenerator\Commands\Services;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

// class ControllerGeneratorService implements GeneratorContrat {
class IndexGeneratorService {

    /**
     * Cette methode permet de générer le header du tableau dans la pagne index
     *
     * @param Collection $table
     * @return void
     */
    private function tableHeader(Collection $table){
        $table_header = "";
        foreach ($table as $key => $colonne) {
            if ($colonne[0] != 'id' && $colonne[0] != 'created_at' && $colonne[0] != 'updated_at') {
                $table_header .= ($key == 0 ? "" : "\n\t\t\t\t\t\t") . "<th> " . Str::ucfirst($colonne[0]) . " </th>";
            }
        }
        return $table_header;
    }

    /**
     * Cette methode permet de générer le corps du tableau dans la pagne index
     *
     * @param Collection $table
     * @param String $model
     * @return void
     */
    private function tableBody(Collection $table, String $model){
        $table_body = '';
        foreach ($table as $key => $colonne) {
            if ($colonne[0] != 'id' && $colonne[0] != 'created_at' && $colonne[0] != 'updated_at') {
                $table_body .= ($key == 0 ? "" : "\n\t\t\t\t\t\t\t") . "<td> {{ $" . Str::lower($model) . '->' . $colonne[0] . " }} </td>";
            }
        }
        return $table_body;
    }

    /**
     * Cette methode permet la génération de la page index
     *
     * @param String $model
     * @param Collection $table
     * @return void
     */
    public function generate(String $model, Collection $table){
        $index_stub = file_get_contents(__DIR__ . "/../stubs/views/index.stub");

        // Ici on défini comment seront changées les différentes variables présents dans le fichier stub de la vue
        // Dans ledit fichier, les variables sont précédées d'un "#"
        $replace = [
            "#layout" => config('allGeneratorConfig.layout'),
            "#section" => config('allGeneratorConfig.section'),

            "#titre" => config('allGeneratorConfig.index_title') ?? ($model . 's Liste'),
            "#create_text" => config('allGeneratorConfig.index_create_text') ?? ('Create ' . $model),
            "#NoData_message" => config('allGeneratorConfig.NoData_message'),

            "#models" => '$' . Str::lower($model) . 's',
            "#model" => '$' . Str::lower($model),
            "#create_root" => Str::lower($model) . 's.create',
            "#edit_route" => "'" . Str::lower($model) . 's.edit\', $' . Str::lower($model) . '?->id',

            "#table_head" => $this->tableHeader($table),
            "#table_body" => $this->tableBody($table, $model),
            "#colspan" => $table->count() - 3,
        ];

        $index_stub = str_replace(array_keys($replace), array_values($replace), $index_stub);
        File::put(base_path() . '/resources/views/' . Str::lower($model) . 's/' . 'index.blade.php', $index_stub);
    }

}

