<?php

declare(strict_types=1);

namespace Yiisoft\Serializer\Tests\TestAsset;

use JsonSerializable;

final class DummyDataJsonSerializable implements JsonSerializable
{
    private string $data;

    public function __construct(string $data)
    {
        $this->data = $data;
    }

    public function getData(): string
    {
        return $this->data;
    }

    public function jsonSerialize(): array
    {
        return [
            'data' => 'jsonSerialize',
        ];
    }
}
