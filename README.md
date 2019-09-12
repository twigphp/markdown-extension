Twig Markdown Extension
=======================

This package provides a Markdown to HTML filter (`markdown`) and an HTML to
Markdown filter (`html_to_markdown`) for Twig and a Symfony bundle.

Install using [Composer](https://getcomposer.org/):

```bash
composer require twig/markdown-extension
```

If you are not using Symfony, register the extension on Twig's `Environment`
manually:

```php
use Twig\Markdown\MarkdownExtension;
use Twig\Environment;

$twig = new Environment(...);
$twig->addExtension(new MarkdownExtension());
```

You must also register the extension runtime (skip this step if you are using
Symfony or a framework with a Twig integration):

```php
use Twig\Markdown\DefaultMarkdown;
use Twig\Markdown\MarkdownRuntime;
use Twig\RuntimeLoader\RuntimeLoaderInterface;

$twig->addRuntimeLoader(new class implements RuntimeLoaderInterface {
    public function load($class) {
        if (MarkdownRuntime::class === $class) {
            return new MarkdownRuntime(new DefaultMarkdown());
        }
    }
});
```

Use the `markdown` and `html_to_markdown` filters from a Twig template:

```twig
{% filter markdown %}
Title
======

Hello!
{% endfilter %}

{% filter html_to_markdown %}
    <html>
        <h1>Hello!</h1>
    </html>
{% endfilter %}
```

Note that you can indent the Markdown content as leading whitespaces will be
removed consistently before conversion:

```twig
{% filter markdown %}
    Title
    ======

    Hello!
{% endfilter %}
```

You can also add some options by passing them as an argument to the filter:

```twig
{% filter html_to_markdown({hard_break: false}) %}
    <html>
        <h1>Hello!</h1>
    </html>
{% endfilter %}
```

You can also use the filters on an included file:

```twig
{{ include('some_template.html.twig')|html_to_markdown }}

{{ include('some_template.markdown.twig')|markdown }}
```
