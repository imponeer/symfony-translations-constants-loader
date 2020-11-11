<?php

namespace Imponeer\SymfonyTranslationsConstantsLoader;

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
     */
    public function formatCatalogue(MessageCatalogue $messages, string $domain, array $options = [])
    {
        $output = '';

        foreach ($messages->all($domain) as $source => $target) {
            $output .= sprintf("define(%s, %s);\n", json_encode((string)$source), json_encode((string)$target));
        }

        return $output;
    }

    /**
     * @inheritDoc
     */
    protected function getExtension()
    {
        return 'php';
    }
}