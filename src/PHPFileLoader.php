<?php

namespace Imponeer\SymfonyTranslationsConstantsLoader;

use Symfony\Component\Translation\Exception\NotFoundResourceException;
use Symfony\Component\Translation\Loader\LoaderInterface;
use Symfony\Component\Translation\MessageCatalogue;

/**
 * Implements php constants file loader
 *
 * @package Imponeer\SymfonyTranslationsConstantsLoader
 */
class PHPFileLoader implements LoaderInterface
{

    /**
     * @inheritDoc
     */
    public function load($resource, string $locale, string $domain = 'messages')
    {
        if (!file_exists($resource)) {
            throw new NotFoundResourceException($resource . ' is not found');
        }

        $content = '<?php ' . PHP_EOL .
            'namespace Imponeer\\SymfonyTranslationsConstantsLoader\\Temp\\Dummy' . md5(mt_rand(0, PHP_INT_MAX)) . ';' . PHP_EOL .
            'use ' . TempConstantsBag::class . ';' . PHP_EOL .
            'function define($constant, $value) {' . PHP_EOL .
            '  TempConstantsBag::define($constant, $value);' . PHP_EOL .
            '}' . PHP_EOL .
            '?>' . file_get_contents($resource);

        {
            eval('?>' . $content);
        }

        $messageCatalogue = new MessageCatalogue($locale);
        $messageCatalogue->add(
            TempConstantsBag::getAll(),
            $domain
        );
        TempConstantsBag::clear();

        return $messageCatalogue;
    }
}