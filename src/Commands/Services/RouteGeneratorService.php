<?php

namespace Baiss\ViewGenerator\Commands\Services;

use Illuminate\Support\Str;

// class ControllerGeneratorService implements GeneratorContrat {
class RouteGeneratorService {

    /**
     * Cette methode permet la création d'un dichier de route nommée all_generate_routes.php qui renfermera toute nos routes générée
     * Elle ajoutera une extenssion de all_generate_routes.php dans le web.php
     * Elle créra une route ressource pour le module en cour de génération
     *
     * @param String $model
     * @return void
     */
    public function generate(String $model){
        // Création du fichier all_generate_routes.php si il n'existe pas
        if (!file_exists(base_path() . "/routes/all_generate_routes.php")) {
            file_put_contents(base_path() . "/routes/all_generate_routes.php", file_get_contents(__DIR__ . "/../stubs/routes.stub" ));
        }

        // Extention du fichier all_generate_routes.php dans web.php si ce n'est pas encore le cas
        $routes = file_get_contents(base_path() . "/routes/web.php");
        if (!Str::contains($routes, "require __DIR__.'/all_generate_routes.php'")) {
            $routes .= "\n\nrequire __DIR__.'/all_generate_routes.php';";
            file_put_contents(base_path() . "/routes/web.php", $routes);
        }

        // Ajout de notre route ressource si une telle route n'existe pas encore
        $all_generate_routes = file_get_contents(base_path() . "/routes/all_generate_routes.php");
        if (!Str::contains($all_generate_routes, "Route::resource('" . Str::lower($model) . 's' )) {
            $all_generate_routes .= "\nRoute::resource('" . Str::lower($model) . "s', " . $model . "Controller::class);//->middleware(['auth', 'verified'])";
            file_put_contents(base_path() . "/routes/all_generate_routes.php", $all_generate_routes);
        }
    }

}

