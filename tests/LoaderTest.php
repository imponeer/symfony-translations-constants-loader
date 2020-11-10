<?php


namespace Imponeer\Tests\SymfonyTranslationsConstantsLoader;

use Imponeer\SymfonyTranslationsConstantsLoader\PHPFileLoader;
use Symfony\Component\Translation\Translator;

class LoaderTest extends \PHPUnit\Framework\TestCase
{

    public function testLoader()
    {
        $translation = new Translator('en');
        $translation->addLoader('php', new PHPFileLoader());
        $translation->addResource('php', __DIR__ . '/data/dummy.en.php', 'en', 'dummy');
        $translation->addResource('php', __DIR__ . '/data/dummy.lt.php', 'lt', 'dummy');

        $this->assertSame(
            'Test',
            $translation->trans('_T_NAME', [], 'dummy', 'en'),
            'English translation for failed'
        );
        $this->assertSame(
            'Testas',
            $translation->trans('_T_NAME', [], 'dummy', 'lt'),
            'Lithuanian translation for failed'
        );
    }

}