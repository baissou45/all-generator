<?php

namespace Baiss\ViewGenerator\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use Baiss\ViewGenerator\Commands\Services\ControllerGeneratorService;
use Baiss\ViewGenerator\Commands\Services\CreateGeneratorService;
use Baiss\ViewGenerator\Commands\Services\EditGeneratorService;
use Baiss\ViewGenerator\Commands\Services\FormGeneratorService;
use Baiss\ViewGenerator\Commands\Services\IndexGeneratorService;
use Baiss\ViewGenerator\Commands\Services\ModelGeneratorService;
use Baiss\ViewGenerator\Commands\Services\RouteGeneratorService;

class Generate extends Command {

    protected $signature = "all:generate
            {model : This is the model attached to the migration you want to do the generations of}
            {--a|all : This option allows you to generate everything}";

    protected $description = 'This command allows the generation of control files such as a controller, a model and views from a migration.';

    /**
     * Cette methode est la methode phare de la commande
     * Elle permet de faire les différents controlles afin d'appeler les bons services
     * pour effectuer des actions précises en fonction des choix de l'utilisateur
     *
     * @return void
     */
    public function handle() {
        // Checker si l'oprion all est passée en parmettre afin de sasoir
        // s'il faut lancer la succession de question reponse avec le client
        if ($this->option('all')) {
            $options['controller'] = true;
            $options['model'] = true;
            $options['route'] = true;
            $options['views'] = true;
            $options['index'] = true;
            $options['form'] = true;
        } else {
            $options = $this->questions();
        }

        $table = collect([]);
        $table_name = Str::lower($this->argument('model') . 's');

        $this->newLine();
        $this->comment('---------- Executing the build query ----------');

        // Initialisée la variable table avec les un enssemble clef valeur pour connaitre les types des champs
        foreach (Schema::getColumnListing(Str::lower($this->argument('model') . 's')) as $field) {
            $type = Schema::getColumnType($table_name, $field);
            $table->push([$field, $type]);
        }

        // Si l'option model est définie, procéder à la génération du model en fonction des champs dans ma base de données
        if ($options['model']) {
            (new ModelGeneratorService)->generate($this->argument('model'), $table);
            $this->newLine();
            $this->comment($this->getBadge('CONTROLLER') . ' [app/Http/Controllers/' . $this->argument('model') . 'Controller' . '.php] created successfull');
        }

        // Si l'option route est définie, procéder à la génération des routes ressources et du fichier all_generate_routes.php
        if ($options['route']) {
            (new RouteGeneratorService)->generate($this->argument('model'), $table);
            $this->comment($this->getBadge('ROUTE') . " [routes/all_generate_routes.php] created successfull");
        }

        // Si l'option controller est définie, procéder à la génération du controller avec les traits pour un CRUD par defaut
        if ($options['controller']) {
            (new ControllerGeneratorService)->generate($this->argument('model'), $table);
            $this->info($this->getBadge('MODEL') . ' [app/Models/' . $this->argument('model') . '.php] created successfull');
            $this->newLine();
        }

        // Si l'option view est définie, procéder à la génération des vues
        if ($options['views']) {

            if ($options['index']) {

                // Créer le dossier du modules dans /resources/views/
                // Il s'agit du dossier qui renferme les différents fichiers de vue  du model
                if (!file_exists(base_path() . '/resources/views/' . Str::lower($this->argument('model')) . 's')) {
                    mkdir(base_path() . '/resources/views/' . Str::lower($this->argument('model')) . 's', 0777, true);
                }

                // Génération du fichier index.blade.php avec la logiuqe de listing des
                // données rattachées a la migration de la classe saisie
                (new IndexGeneratorService)->generate($this->argument('model'), $table);
                $this->comment($this->getBadge('VIEW : Index') . ' [resources/views/' . Str::lower($this->argument('model')) . "s/index.blade.php] created successfull");
            }

            // Si l'option form est définie, passer à la génération des fichiers de formulaire
            if ($options['form']) {

                // Créer le dossier partials pour le module s'il n'esxiste pas
                if (!file_exists(base_path() . '/resources/views/' . $this->argument('model') . 's/partials')) {
                    mkdir(base_path() . '/resources/views/' . $this->argument('model') . 's/partials', 0777, true);
                }

                // Procéder à la génération de la page create s'il n'existe pas
                if (!file_exists(base_path() . '/resources/views/' . Str::lower($this->argument('model')) . 's/create.blade.php')) {
                    (new CreateGeneratorService)->generate($this->argument('model'), $table);
                    $this->comment($this->getBadge('VIEW : Create') . ' [resources/views/' . Str::lower($this->argument('model')) . "s/create.blade.php] created successfull");
                } else {
                    $this->newLine();
                    $this->error("[resources/views/" . Str::lower($this->argument('model')) . "s/create.blade.php] ready exist");
                    $this->newLine();
                }

                // Procéder à la génération de la edit create s'il n'existe pas
                if (!file_exists(base_path() . '/resources/views/' . Str::lower($this->argument('model')) . 's/edit.blade.php')) {
                    (new EditGeneratorService)->generate($this->argument('model'), $table);
                    $this->comment($this->getBadge('VIEW : Edit') . ' [resources/views/' . Str::lower($this->argument('model')) . "s/edit.blade.php] created successfull");
                } else {
                    $this->newLine();
                    $this->error("[resources/views/" . Str::lower($this->argument('model')) . "s/edit.blade.php] ready exist");
                    $this->newLine();
                }

                // Procéder à la génération de la page form dans le dossier partials s'il n'existe pas
                if (!file_exists(base_path() . '/resources/views/' . Str::lower($this->argument('model')) . 's/partials/form.blade.php')) {
                    (new FormGeneratorService)->generate($this->argument('model'), $table);
                    $this->comment($this->getBadge('VIEW : Form') . ' [resources/views/' . Str::lower($this->argument('model')) . "s/partials/form.blade.php] created successfull");
                } else {
                    $this->newLine();
                    $this->error("[resources/views/" . Str::lower($this->argument('model')) . "s/partials/form.blade.php] ready exist");
                    $this->newLine();
                }

            }
        }

        $this->newLine();
        $this->comment('-------------- End of generation --------------');
        $this->newLine();

        return Command::SUCCESS;
    }

    /**
     * Cette methode permet la génération du badge dans la console
     *
     * @param String $text
     * @return void
     */
    private function getBadge(String $text){
        return $badge = "\e[1;44m " . $text . " \e[0m";
    }

    /**
     * Cette fonction permet de lancer une série de question réponse pour savoir
     * les différents fichiers que l'utilisateur souhaite générer
     *
     * @return void
     */
    private function questions(){
        $options = collect();
        $options['controller'] = $this->confirm('Do you want to generate the controller ?', true);
        $options['model'] = $this->confirm('Do you want to generate the model ?', true);
        $options['route'] = $this->confirm('Do you want to generate the route ?', true);
        if ($this->confirm('Do you want to generate the views ?', true)) {
            $options['views'] = true;
            $options['index'] = $this->confirm('Do you want to generate the index view ?', true);
            $options['form'] = $this->confirm('Do you want to generate the Create and Edit form view ?', true);
        }
        return $options;
    }

}
