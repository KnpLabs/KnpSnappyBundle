KnpSnappyBundle
===============

![Build Status](https://github.com/KnpLabs/KnpSnappyBundle/actions/workflows/build.yaml/badge.svg)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/KnpLabs/KnpSnappyBundle/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/KnpLabs/KnpSnappyBundle/?branch=master)
[![StyleCI](https://styleci.io/repos/743218/shield?branch=master)](https://styleci.io/repos/743218)

[Snappy][snappy] is a PHP wrapper for the [wkhtmltopdf][wkhtmltopdf] conversion utility.
It allows you to generate either pdf or image files from your html documents, using the webkit engine.

The KnpSnappyBundle provides a simple integration for your Symfony project.

Limitations
----------

If you use JavaScript to render your pages, you may encounter some issues because of [wkhtmltopdf][wkhtmltopdf] not being fully compatible with ES6 apis.
The only way to solve this issue is to provide polyfills that fix the gaps between modern ES6 apis and the [wkhtmltopdf][wkhtmltopdf] rendering engine.

Installation
------------

With [composer](https://getcomposer.org), require:

`composer require knplabs/knp-snappy-bundle`

Then enable it in your kernel (optional if you are using the Flex recipe with Symfony >= 4) :

```php
// config/bundles.php
<?php

return [
    //...
    Knp\Bundle\SnappyBundle\KnpSnappyBundle::class => ['all' => true],
    //...
];
```
Configuration
-------------

If you need to change the binaries, change the instance options or even disable one or both services, you can do it through the configuration.

```yaml
# app/config/config.yml (or config/packages/knp_snappy.yaml if using Symfony4 and the Flex recipe)
knp_snappy:
    pdf:
        enabled:    true
        binary:     /usr/local/bin/wkhtmltopdf #"\"C:\\Program Files\\wkhtmltopdf\\bin\\wkhtmltopdf.exe\"" for Windows users
        options:    []
    image:
        enabled:    true
        binary:     /usr/local/bin/wkhtmltoimage #"\"C:\\Program Files\\wkhtmltopdf\\bin\\wkhtmltoimage.exe\"" for Windows users
        options:    []
```

If you want to change temporary folder which is ```sys_get_temp_dir()``` by default, you can use

```yaml
# app/config/config.yml (or config/packages/knp_snappy.yaml if using Symfony4 and the Flex recipe)
knp_snappy:
    temporary_folder: "%kernel.cache_dir%/snappy"
```

You can also configure the timeout used by the generators with `process_timeout`:

```yaml
# app/config/config.yml (or config/packages/knp_snappy.yaml if using Symfony4 and the Flex recipe)
knp_snappy:
    process_timeout: 20 # In seconds
```

Usage
-----

The bundle registers two services:

 - the `knp_snappy.image` service allows you to generate images;
 - the `knp_snappy.pdf` service allows you to generate pdf files.

### Generate an image from a URL

```php
// @var Knp\Snappy\Image
$knpSnappyImage->generate('http://www.google.fr', '/path/to/the/image.jpg');
```

### Generate a pdf document from a URL

```php
// @var Knp\Snappy\Pdf
$knpSnappyPdf->generate('http://www.google.fr', '/path/to/the/file.pdf');
```

### Generate a pdf document from multiple URLs

```php
// @var Knp\Snappy\Pdf
$knpSnappyPdf->generate(array('http://www.google.fr', 'http://www.knplabs.com', 'http://www.google.com'), '/path/to/the/file.pdf');
```

### Generate a pdf document from a twig view

```php
// @var Knp\Snappy\Pdf
$knpSnappyPdf->generateFromHtml(
    $this->renderView(
        'MyBundle:Foo:bar.html.twig',
        array(
            'some'  => $vars
        )
    ),
    '/path/to/the/file.pdf'
);
```

### Render an image as response from a controller

```php
use Knp\Bundle\SnappyBundle\Snappy\Response\JpegResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class SomeController extends AbstractController
{
    public function imageAction(Knp\Snappy\Image $knpSnappyImage)
    {
        $html = $this->renderView('MyBundle:Foo:bar.html.twig', array(
            'some'  => $vars
        ));

        return new JpegResponse(
            $knpSnappyImage->getOutputFromHtml($html),
            'image.jpg'
        );
    }
}
```

### Render a pdf document as response from a controller

```php
use Knp\Bundle\SnappyBundle\Snappy\Response\PdfResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class SomeController extends AbstractController
{
    public function pdfAction(Knp\Snappy\Pdf $knpSnappyPdf)
    {
        $html = $this->renderView('MyBundle:Foo:bar.html.twig', array(
            'some'  => $vars
        ));

        return new PdfResponse(
            $knpSnappyPdf->getOutputFromHtml($html),
            'file.pdf'
        );
    }
}
```

### Render a pdf document with a relative url inside like css files

```php
use Knp\Bundle\SnappyBundle\Snappy\Response\PdfResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class SomeController extends AbstractController
{
    public function pdfAction(Knp\Snappy\Pdf $knpSnappyPdf)
    {
        $pageUrl = $this->generateUrl('homepage', array(), true); // use absolute path!

        return new PdfResponse(
            $knpSnappyPdf->getOutput($pageUrl),
            'file.pdf'
        );
    }
}
```

Maintainers
-----------

KNPLabs is looking for maintainers ([see why](https://knplabs.com/en/blog/news-for-our-foss-projects-maintenance)).

If you are interested, feel free to open a PR to ask to be added as a maintainer.

We’ll be glad to hear from you :)

Credits
-------

SnappyBundle and [Snappy][snappy] are based on the awesome [wkhtmltopdf][wkhtmltopdf].
SnappyBundle has been developed by [KnpLabs][KnpLabs].

[snappy]: https://github.com/KnpLabs/snappy
[wkhtmltopdf]: http://wkhtmltopdf.org
[KnpLabs]: http://www.knplabs.com
