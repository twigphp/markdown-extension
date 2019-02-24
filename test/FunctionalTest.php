<?php

namespace Twig\Markdown\Tests;

use PHPUnit\Framework\TestCase;
use Twig\Environment;
use Twig\Loader\ArrayLoader;
use Twig\Markdown\DefaultMarkdown;
use Twig\Markdown\ErusevMarkdown;
use Twig\Markdown\LeagueMarkdown;
use Twig\Markdown\MarkdownExtension;
use Twig\Markdown\MarkdownRuntime;
use Twig\Markdown\MichelfMarkdown;
use Twig\RuntimeLoader\RuntimeLoaderInterface;

class FunctionalTest extends TestCase
{
    /**
     * @dataProvider getMardownTests
     */
    public function testMarkdown(string $template, string $expected): void
    {
        foreach ([LeagueMarkdown::class, ErusevMarkdown::class, MichelfMarkdown::class, DefaultMarkdown::class] as $class) {
            $twig = new Environment(new ArrayLoader([
                'index' => $template,
                'html' => <<<EOF
Hello
=====

Great!
EOF
            ]));
            $twig->addExtension(new MarkdownExtension());
            $twig->addRuntimeLoader(new class($class) implements RuntimeLoaderInterface {
                private $class;

                public function __construct(string $class)
                {
                    $this->class = $class;
                }

                public function load($c)
                {
                    if (MarkdownRuntime::class === $c) {
                        return new $c(new $this->class());
                    }
                }
            });
            $this->assertRegExp('{'.$expected.'}m', trim($twig->render('index')));
        }
    }

    public function getMardownTests()
    {
        return [
            [<<<EOF
{% filter markdown %}
Hello
=====

Great!
{% endfilter %}
EOF
            , "<h1>Hello</h1>\n+<p>Great!</p>"],
            ["{{ include('html')|markdown }}", "<h1>Hello</h1>\n+<p>Great!</p>"],
        ];
    }

    /**
     * @dataProvider getHtmlToMardownTests
     */
    public function testHtmlToMarkdown(string $template, string $expected): void
    {
        $twig = new Environment(new ArrayLoader([
            'index' => $template,
            'html' => <<<EOF
<html>
    <h1>Hello</h1>
    <p><b>Great!</b></p>
</html>
EOF
        ]));
        $twig->addExtension(new MarkdownExtension());
        $this->assertEquals($expected, $twig->render('index'));
    }

    public function getHtmlToMardownTests()
    {
        return [
            [<<<EOF
{% filter html_to_markdown %}
    <html>
        <h1>Hello</h1>
        <p><b>Great!</b></p>
    </html>
{% endfilter %}
EOF
            , "Hello\n=====\n\n**Great!**"],
            [<<<EOF
{% filter html_to_markdown({hard_break: false}) %}
    <html>Great<br>Break</html>
{% endfilter %}
EOF
            , "Great  \nBreak"],
            ["{{ include('html')|html_to_markdown }}", "Hello\n=====\n\n**Great!**"],
        ];
    }
}
