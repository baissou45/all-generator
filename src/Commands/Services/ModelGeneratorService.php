<?php

namespace Baiss\ViewGenerator\Commands\Services;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

// class ControllerGeneratorService implements GeneratorContrat {
class ModelGeneratorService {

    /**
     * Cette methode pemet la génération des fillables
     *
     * @param Collection $table
     * @return void
     */
    private function generate_fillable(Collection $table){
        $fillable = '[';
        foreach ($table as $key => $column) {
            if ($column[0] != 'id' && $column[0] != 'created_at' && $column[0] != 'updated_at') {
                $fillable .= "\n\t\t'" . $table[$key][0] . ($table->keys()->last() == $key ? "'" : "',");
            }
        }
        $fillable .= "\n\t];";
        return $fillable;
    }

    /**
     * On défini aussi, si absent, la méthode inverse dans la table avec laquelle la relation est définie
     *
     * @param String $model
     * @param String $related_field
     * @return void
     */
    private function generate_related_class_relations(String $model, String $related_field){
        $relation_stub = file_get_contents(__DIR__ . "/../stubs/relation.stub");

        $related_table = "App\Models\\". Str::ucfirst(str_replace('_id', '', $related_field));
        $belongs_function = Str::lower(str_replace('_id', '', $model) . 's');

        $related_model_data = file_get_contents(app_path() . '/Models//' . Str::ucfirst(str_replace('_id', '', $related_field)) . '.php');
        $related_model_data = Str::beforeLast($related_model_data, '}');

        // Si la méthode de liaison dans la table de liaison n'est pas définie, la créer
        if(!method_exists($related_table, $belongs_function)){
            $replace = [
                '#methode_name' => Str::lower(str_replace('_id', '', $model) . 's'),
                '#relation_type' => 'hasMany',
                '#related_class' => Str::ucfirst(str_replace('_id', '', $related_field)),
            ];

            $related_model_data .= "\n\t" . str_replace(array_keys($replace), array_values($replace), $relation_stub) . "\n}";
            File::put(app_path() . '/Models//' . Str::ucfirst(str_replace('_id', '', $related_field)) . '.php', $related_model_data);
        };
    }

    /**
     * Ici, on défini les différentes relations à intégrées dans le model en cours de génération
     *
     * @param String $model
     * @param Collection $table
     * @return void
     */
    private function generate_relations(String $model, Collection $table){
        $relations = '';
        $relation_stub = file_get_contents(__DIR__ . "/../stubs/relation.stub");

        foreach ($table as $key => $column) {
            if (Str::contains($table[$key][0], '_id')) {
                $replace = [
                    '#methode_name' => str_replace('_id', '', $table[$key][0]),
                    '#relation_type' => 'belongsTo',
                    '#related_class' => Str::ucfirst(str_replace('_id', '', $table[$key][0])),
                ];
                $relations .= str_replace(array_keys($replace), array_values($replace), $relation_stub);

                // Vérification si le model de liaison est déjà défini
                if(file_exists(app_path() . '/Models//' . Str::ucfirst(str_replace('_id', '', $table[$key][0])) . '.php')){
                    $this->generate_related_class_relations($model, $table[$key][0]);
                }
            }
        }

        return $relations;
    }

    /**
     * Il s'agit ici d'une methode qui permet la génération de model
     * Elle génere la vue avec des éléments comme le fillable, les relations belongsTo quand les
     * conventions de nommage sont respectées, mais aussi les hasMany dans la classe de liaison si elle n'existe pas
     *
     * @param String $model
     * @param Collection $table
     * @return void
     */
    public function generate(String $model, Collection $table){
        $model_stub = file_get_contents(__DIR__ . "/../stubs/model.stub");

        $replace = [
            '#model' => $model,
            '#fillable' => $this->generate_fillable($table),
            '#relations' => $this->generate_relations($model, $table),
        ];

        $generated_model = str_replace(array_keys($replace), array_values($replace), $model_stub);
        File::put(app_path() . '/Models//' . $model . '.php', $generated_model);
    }

}

