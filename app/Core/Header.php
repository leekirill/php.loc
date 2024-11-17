<?php

declare(strict_types=1);

class Header
{
    public function __construct(
        public string $name,
        public array  $values = [],
    )
    {
    }

    public function add(mixed $value): void
    {
        $this->values[] = $value;
    }
}