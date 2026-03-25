<?php

declare(strict_types=1);

final class Statistics
{
    /** @var array<int> */
    private array $numeros;

    public function __construct(array $numeros)
    {
        $this->numeros = $numeros;
    }

    public function getSuma(): int
    {
        return array_sum($this->numeros);
    }

    public function getPromedio(): float
    {
        if (count($this->numeros) === 0) {
            return 0.0;
        }
        return round(array_sum($this->numeros) / count($this->numeros), 2);
    }

    public function getMinimo(): int
    {
        if (count($this->numeros) === 0) {
            return 0;
        }
        return min($this->numeros);
    }

    public function getMaximo(): int
    {
        if (count($this->numeros) === 0) {
            return 0;
        }
        return max($this->numeros);
    }
}
