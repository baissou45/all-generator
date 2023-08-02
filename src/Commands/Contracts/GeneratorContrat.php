<?php

namespace Baiss\ViewGenerator\Commands\Contracts;

interface GeneratorContrat {
    public function generate($model, $table);
}

