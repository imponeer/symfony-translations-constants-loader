<?php


namespace Imponeer\Tests\SymfonyTranslationsConstantsLoader;

use Imponeer\SymfonyTranslationsConstantsLoader\PHPFileLoader;
use org\bovigo\vfs\vfsStream;
use org\bovigo\vfs\vfsStreamDirectory;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Translation\Translator;

class LoaderTest extends TestCase
{
    private vfsStreamDirectory $fileSystem;

    /**
     * @var array<string, array<string, string>>
     */
    private array $localData = [];

    protected function setUp(): void
    {
        $this->localData = [
            'en' => [
                '_T_VALUE_1' => sha1(microtime(true) . random_int(PHP_INT_MIN, PHP_INT_MAX)),
                '_T_VALUE_2' => sha1(microtime(true) . random_int(PHP_INT_MIN, PHP_INT_MAX)),
            ],
            'lt' => [
                '_T_VALUE_1' => md5(microtime(true) . random_int(PHP_INT_MIN, PHP_INT_MAX)),
                '_T_VALUE_2' => md5(microtime(true) . random_int(PHP_INT_MIN, PHP_INT_MAX)),
            ],
        ];

        $filesystem = [
            'translations' => [],
        ];
        foreach ($this->localData as $lang => $translations) {
            $data = '<?php ' . PHP_EOL;
            foreach ($translations as $from => $to) {
                $data .= sprintf(
                    "define(%s, %s);",
                        json_encode((string)$from, JSON_THROW_ON_ERROR),
                        json_encode((string)$to, JSON_THROW_ON_ERROR)
                    ) . PHP_EOL;
            }
            $filesystem['translations'][$lang] = $data;
        }

        $this->fileSystem = vfsStream::setup('tmp', null, $filesystem);
    }

    public function testLoader(): void
    {
        $translation = new Translator('en');
        $translation->addLoader('php', new PHPFileLoader());
        foreach ($this->localData as $lang => $translations) {
            $translation->addResource(
                'php',
                $this->fileSystem->url() . '/translations/' . $lang,
                $lang,
                'dummy'
            );
        }

        foreach ($this->localData as $lang => $translations) {
            foreach ($translations as $from => $to) {
                $this->assertSame(
                    $to,
                    $translation->trans($from, [], 'dummy', $lang),
                    $lang . ' translation for failed'
                );
            }
        }
    }

}