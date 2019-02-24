Twig Markdown Extension
=======================

This package provides a Mardown to HTML filter (`markdown`) and an HTML to
Markdown filter (`html_to_markdown`) for Twig and a Symfony bundle.

If you are not using Symfony, register the extension on Twig's `Environment`
manually:

```php
use Twig\Markdown\MarkdownExtension;
use Twig\Environment;

$twig = new Environment(...);
$twig->addExtension(new MarkdownExtension());
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
