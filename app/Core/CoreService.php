<?php

namespace App\Core;

abstract class CoreService
{
    protected $repository;

    public function __construct($repository)
    {
        $this->repository = $repository;
    }

}
