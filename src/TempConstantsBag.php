<?php

namespace Imponeer\SymfonyTranslationsConstantsLoader;

use Stringable;

/**
 * Class to handle some temporary constants data
 *
 * @package Imponeer\SymfonyTranslationsConstantsLoader
 */
final class TempConstantsBag
{
    /**
     * Temp data
     *
     * @var array<string, string>
     */
    private static $data = [];

    /**
     * Disabled TempConstantsBag constructor.
     */
    private function __construct()
    {
    }

    /**
     * Fake constant definer
     *
     * @param string $constant Constant to define
     * @param mixed $value Value of constant
     */
    public static function define(string $constant, string|int|float|Stringable $value): void
    {
        self::$data[$constant] = (string)$value;
    }

    /**
     * Clear current data
     */
    public static function clear(): void
    {
        self::$data = [];
    }

    /**
     * Get all stored data
     *
     * @return array
     */
    public static function getAll(): array
    {
        return self::$data;
    }

}