<?php

declare(strict_types=1);

final class NumberGenerator
{
    private int $n;
    private int $min;
    private int $max;

    public function __construct(int $n, int $min, int $max)
    {
        $this->n = $n;
        $this->min = $min;
        $this->max = $max;
    }

    /**
     * @return array<int>
     */
    public function generate(): array
    {
        $numeros = [];
        for ($i = 0; $i < $this->n; $i++) {
            $numeros[] = random_int($this->min, $this->max);
        }
        return $numeros;
    }
}
