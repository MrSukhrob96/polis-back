<?php

namespace App\Core;

abstract class CoreDTO
{
    public abstract function toArray(): array;
}
