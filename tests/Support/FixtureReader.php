<?php

namespace FsHub\Sdk\Tests\Support;

class FixtureReader
{
    public static function Read(string $file): string
    {
        $fixtureFilePath = __FILE__ . '../Fixtures/' . $file;
        return file_get_contents($fixtureFilePath);
    }
}