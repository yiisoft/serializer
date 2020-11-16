<?php

declare(strict_types=1);

namespace Yiisoft\Serializer\Tests\TestAsset;

use function preg_replace;
use function sprintf;

final class DummyDataHelper
{
    public static function xml(string $data, string $version = '1.0', string $encoding = 'UTF-8'): string
    {
        $startLine = sprintf('<?xml version="%s" encoding="%s"?>', $version, $encoding);
        return $startLine . PHP_EOL . preg_replace('/(?!item)\s(?!key)/', '', $data) . PHP_EOL;
    }
}
