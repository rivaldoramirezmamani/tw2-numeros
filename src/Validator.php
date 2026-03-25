<?php

declare(strict_types=1);

final class Validator
{
    private const DEFAULT_MIN = 1;
    private const DEFAULT_MAX = 100;
    private const MIN_N = 1;
    private const MAX_N = 1000;
    private const MIN_RANGO = 1;
    private const MAX_RANGO = 10000;

    /** @var array<int, string> */
    private array $errores = [];

    private int $n;
    private int $rangoMin;
    private int $rangoMax;

    public function validate(array $data): bool
    {
        $this->errores = [];
        $this->n = self::DEFAULT_MIN;
        $this->rangoMin = self::DEFAULT_MIN;
        $this->rangoMax = self::DEFAULT_MAX;

        $n = $this->validarEntero($data['n'] ?? '');
        if ($n === null) {
            $this->errores[] = 'El campo "Cantidad de números" debe ser un número entero.';
        } elseif ($n < self::MIN_N || $n > self::MAX_N) {
            $this->errores[] = 'La cantidad debe estar entre ' . self::MIN_N . ' y ' . self::MAX_N . '.';
        } else {
            $this->n = $n;
        }

        $rangoMin = $this->validarEntero($data['rango_min'] ?? '');
        if ($rangoMin === null && $data['rango_min'] !== '') {
            $this->errores[] = 'El campo "Rango mínimo" debe ser un número entero.';
        } elseif ($rangoMin !== null) {
            if ($rangoMin < self::MIN_RANGO || $rangoMin > self::MAX_RANGO) {
                $this->errores[] = 'El rango mínimo debe estar entre ' . self::MIN_RANGO . ' y ' . self::MAX_RANGO . '.';
            } else {
                $this->rangoMin = $rangoMin;
            }
        }

        $rangoMax = $this->validarEntero($data['rango_max'] ?? '');
        if ($rangoMax === null && $data['rango_max'] !== '') {
            $this->errores[] = 'El campo "Rango máximo" debe ser un número entero.';
        } elseif ($rangoMax !== null) {
            if ($rangoMax < self::MIN_RANGO || $rangoMax > self::MAX_RANGO) {
                $this->errores[] = 'El rango máximo debe estar entre ' . self::MIN_RANGO . ' y ' . self::MAX_RANGO . '.';
            } else {
                $this->rangoMax = $rangoMax;
            }
        }

        if ($rangoMin !== null && $rangoMax !== null && $rangoMin >= $rangoMax) {
            $this->errores[] = 'El rango mínimo debe ser menor que el rango máximo.';
        }

        return count($this->errores) === 0;
    }

    private function validarEntero(string $valor): ?int
    {
        if ($valor === '') {
            return null;
        }
        $resultado = filter_var(trim($valor), FILTER_VALIDATE_INT);
        return $resultado === false ? null : $resultado;
    }

    /**
     * @return array<int, string>
     */
    public function getErrors(): array
    {
        return $this->errores;
    }

    public function getN(): int
    {
        return $this->n;
    }

    public function getRangoMin(): int
    {
        return $this->rangoMin;
    }

    public function getRangoMax(): int
    {
        return $this->rangoMax;
    }
}
