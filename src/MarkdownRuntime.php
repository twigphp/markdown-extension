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

class MarkdownRuntime
{
    private $converter;

    public function __construct(MarkdownInterface $converter)
    {
        $this->converter = $converter;
    }

    public function convert(string $body): string
    {
        return $this->converter->convert($body);
    }
}
