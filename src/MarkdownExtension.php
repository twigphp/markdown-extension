<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Twig\Markdown;

use League\HTMLToMarkdown\HtmlConverter;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class MarkdownExtension extends AbstractExtension
{
    public function getFilters()
    {
        return [
            new TwigFilter('markdown', ['Twig\\Markdown\\MarkdownRuntime', 'convert'], ['is_safe' => ['all']]),
            new TwigFilter('html_to_markdown', 'Twig\\Markdown\\twig_html_to_markdown', ['is_safe' => ['all']]),
        ];
    }
}

function twig_html_to_markdown(string $body, array $options = []): string
{
    static $converters;

    $options = $options + ['hard_break' => true];

    if (!isset($converters[$key = serialize($options)])) {
        $converters[$key] = new HtmlConverter($options);
    }

    return $converters[$key]->convert($body);
}
