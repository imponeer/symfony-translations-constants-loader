<?php

namespace Imponeer\SymfonyTranslationsConstantsLoader;

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
     * @var array
     */
    protected static $data = [];

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
    public static function define($constant, $value): void
    {
        static::$data[$constant] = (string)$value;
    }

    /**
     * Clear current data
     */
    public static function clear(): void
    {
        static::$data = [];
    }

    /**
     * Get all stored data
     *
     * @return array
     */
    public static function getAll(): array
    {
        return static::$data;
    }

}