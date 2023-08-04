<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Configuration du layout
    |--------------------------------------------------------------------------
    |
    | La génération des assets de vue (index, create, edit et form) sont faits
    | de sortes a pouvoir s'insséré facillement dans vos templates bootstrap.
    |
    | === layout ===
    | Cet attribu permet de définir l'emplacement du layout que vous souhaiterez
    | utiliser pour encapsuler les assets de vue
    |
    | === section ===
    | Cet attribu permet de savoir la la section dans laquel vous souhaiterez
    | intégrer les assets de vues générées. Il s'agit généralement du du @yield
    |
    */

    'layout' => 'layouts.back.blanc',
    'section' => 'content',

    /*
    |--------------------------------------------------------------------------
    | Configuration du fichier index.blade.php
    |--------------------------------------------------------------------------
    |
    | === index_title ===
    | Cet attribu permet de définir le titre de la page index
    |
    | === index_create_text ===
    | Cet attribu permet de définir le text du boutton d'ajout sur la page index
    |
    | === NoData_message ===
    | Cet attribu permet de définir un text a afficher dans le table dans le cas
    | où aucune donnée n'est présente dans la table
    |
    */

    "index_title" => null,
    "index_create_text" => null,
    "NoData_message" => "No Data",

    /*
    |--------------------------------------------------------------------------
    | Configuration du fichier create.blade.php
    |--------------------------------------------------------------------------
    |
    | === create_title ===
    | Cet attribu permet de définir le titre de la page create
    |
    | === create_submit_text ===
    | Cet attribu permet de définir le text du boutton de soumission
    |
    | === cancel_reset_text ===
    | Cet attribu permet de définir le text du boutton de resset
    |
    */

    "create_title" => null,
    "create_submit_text" => "Submit",
    "cancel_reset_text" => "Cancel",

    /*
    |--------------------------------------------------------------------------
    | Configuration du fichier edit.blade.php
    |--------------------------------------------------------------------------
    |
    | === edit_title ===
    | Cet attribu permet de définir le titre de la page edit
    |
    | === edit_submit_text ===
    | Cet attribu permet de définir le text du boutton de soumission
    |
    | === edit_cancel_text ===
    | Cet attribu permet de définir le text du boutton de resset
    |
    */

    "edit_title" => null,
    "edit_submit_text" => "Submit",
    "edit_cancel_text" => "Cancel",

];