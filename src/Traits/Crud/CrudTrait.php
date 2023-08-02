<?php

namespace Baiss\ViewGenerator\Traits\Crud;

use Baiss\ViewGenerator\Traits\Crud\partials\CrudCreateTrait;
use Baiss\ViewGenerator\Traits\Crud\partials\CrudDestroyTrait;
use Baiss\ViewGenerator\Traits\Crud\partials\CrudEditTrait;
use Baiss\ViewGenerator\Traits\Crud\partials\CrudIndexTrait;
use Baiss\ViewGenerator\Traits\Crud\partials\CrudShowTrait;
use Baiss\ViewGenerator\Traits\Crud\partials\CrudStoreTrait;
use Baiss\ViewGenerator\Traits\Crud\partials\CrudUpdateTrait;

trait CrudTrait{
    use CrudEditTrait, CrudShowTrait, CrudIndexTrait, CrudStoreTrait, CrudCreateTrait, CrudDestroyTrait, CrudUpdateTrait;
}