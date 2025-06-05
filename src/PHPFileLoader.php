<?php

namespace Imponeer\SymfonyTranslationsConstantsLoader;

use Random\RandomException;
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
     *
     * @throws RandomException
     */
    final public function load(mixed $resource, string $locale, string $domain = 'messages'): MessageCatalogue
    {
        if (!file_exists($resource)) {
            throw new NotFoundResourceException($resource . ' is not found');
        }

        {
            eval('?>' . $this->wrapResourceInVirtualNamespace($resource));
        }

        $messageCatalogue = new MessageCatalogue($locale);
        $messageCatalogue->add(
            TempConstantsBag::getAll(),
            $domain
        );
        TempConstantsBag::clear();

        return $messageCatalogue;
    }

    /**
     * @throws RandomException
     */
    private function wrapResourceInVirtualNamespace(string $filename): string
    {
        return '<?php ' . PHP_EOL .
            'namespace ' . $this->generateVirtualNamespaceName() . ';' . PHP_EOL .
            'use ' . TempConstantsBag::class . ';' . PHP_EOL .
            'function define($constant, $value) {' . PHP_EOL .
            '  TempConstantsBag::define($constant, $value);' . PHP_EOL .
            '}' . PHP_EOL .
            '?>' . file_get_contents($filename);
    }

    /**
     * @throws RandomException
     */
    private function generateVirtualNamespaceName(): string
    {
        return sprintf(
            "Imponeer\\SymfonyTranslationsConstantsLoader\\Temp\\Dummy%s",
            md5((string) random_int(0, PHP_INT_MAX))
        );
    }
}
