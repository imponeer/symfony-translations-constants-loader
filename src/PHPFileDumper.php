<?php

namespace Imponeer\SymfonyTranslationsConstantsLoader;

use JsonException;
use Symfony\Component\Translation\Dumper\FileDumper;
use Symfony\Component\Translation\MessageCatalogue;

/**
 * Dumps PHP file as constants list
 *
 * @package Imponeer\SymfonyTranslationsConstantsLoader
 */
class PHPFileDumper extends FileDumper
{
    /**
     * @inheritDoc
     *
     * @noinspection MethodShouldBeFinalInspection
     *
     * @throws JsonException
     */
    public function formatCatalogue(MessageCatalogue $messages, string $domain, array $options = []): string
    {
        $output = '';

        foreach ($messages->all($domain) as $source => $target) {
            $output .= sprintf(
                "define(%s, %s);\n",
                json_encode((string)$source, JSON_THROW_ON_ERROR),
                json_encode((string)$target, JSON_THROW_ON_ERROR)
            );
        }

        return $output;
    }

    /**
     * @inheritDoc
     *
     * @noinspection MethodShouldBeFinalInspection
     * @noinspection MethodVisibilityInspection
     */
    protected function getExtension(): string
    {
        return 'php';
    }
}
