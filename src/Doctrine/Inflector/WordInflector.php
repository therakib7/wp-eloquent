<?php

declare(strict_types=1);

namespace SoftTent\WpEloquent\Doctrine\Inflector;

interface WordInflector
{
    public function inflect(string $word) : string;
}
