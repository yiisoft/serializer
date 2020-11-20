<?php

declare(strict_types=1);

namespace Yiisoft\Serializer\Tests\TestAsset;

final class DummyData
{
    private string $string;
    private int $int;
    private float $float;
    private array $array;
    private bool $bool;

    public function __construct(string $string, int $int, float $float, array $array, bool $bool)
    {
        $this->string = $string;
        $this->int = $int;
        $this->float = $float;
        $this->array = $array;
        $this->bool = $bool;
    }

    public function getString(): string
    {
        return $this->string;
    }

    public function getInt(): int
    {
        return $this->int;
    }

    public function getFloat(): float
    {
        return $this->float;
    }

    public function getArray(): array
    {
        return $this->array;
    }

    /**
     * @param bool $asInt
     *
     * @return bool|int
     */
    public function isBool(bool $asInt = false)
    {
        return $asInt ? (int) $this->bool : $this->bool;
    }
}
