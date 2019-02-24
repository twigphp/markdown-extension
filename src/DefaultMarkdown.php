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

use League\CommonMark\CommonMarkConverter;
use Michelf\MarkdownExtra;
use Parsedown;

class DefaultMarkdown implements MarkdownInterface
{
    private $converter;

    public function __construct()
    {
        if (class_exists(Parsedown::class)) {
            $this->converter = new ErusevMarkdown();
        } elseif (class_exists(CommonMarkConverter::class)) {
            $this->converter = new LeagueMarkdown();
        } elseif (class_exists(MarkdownExtra::class)) {
            $this->converter = new MichelfMarkdown();
        } else {
            throw new \LogicException('You cannot use the "markdown" filter as no Markdown library is available.');
        }
    }

    public function convert(string $body): string
    {
        return $this->converter->convert($body);
    }
}
