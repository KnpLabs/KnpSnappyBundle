KnpSnappyBundle
===============

[![Build Status](https://travis-ci.org/KnpLabs/KnpSnappyBundle.svg?branch=master)](https://travis-ci.org/KnpLabs/KnpSnappyBundle)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/KnpLabs/KnpSnappyBundle/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/KnpLabs/KnpSnappyBundle/?branch=master)
[![StyleCI](https://styleci.io/repos/743218/shield?branch=master)](https://styleci.io/repos/743218)
[![knpbundles.com](http://knpbundles.com/KnpLabs/KnpSnappyBundle/badge-short)](http://knpbundles.com/KnpLabs/KnpSnappyBundle)

[Snappy][snappy] is a PHP (5.6+) wrapper for the [wkhtmltopdf][wkhtmltopdf] conversion utility.
It allows you to generate either pdf or image files from your html documents, using the webkit engine.

The KnpSnappyBundle provides a simple integration for your Symfony project.

Current maintainer(s)
---------------------

* [NiR-](https://github.com/NiR-)

Installation
------------

With [composer](http://packagist.org), require:

`composer require knplabs/knp-snappy-bundle`

Then enable it in your kernel:

```php
// app/AppKernel.php
public function registerBundles()
{
    $bundles = array(
        //...
        new Knp\Bundle\SnappyBundle\KnpSnappyBundle(),
        //...
```
Configuration
-------------

If you need to change the binaries, change the instance options or even disable one or both services, you can do it through the configuration.

```yaml
# app/config/config.yml
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
# app/config/config.yml
knp_snappy:
    temporary_folder: "%kernel.cache_dir%/snappy"
```

You can also configure the timeout used by the generators with `process_timeout`:

```yaml
# app/config/config.yml
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
$container->get('knp_snappy.image')->generate('http://www.google.fr', '/path/to/the/image.jpg');
```

### Generate a pdf document from a URL

```php
$container->get('knp_snappy.pdf')->generate('http://www.google.fr', '/path/to/the/file.pdf');
```

### Generate a pdf document from multiple URLs

```php
$container->get('knp_snappy.pdf')->generate(array('http://www.google.fr', 'http://www.knplabs.com', 'http://www.google.com'), '/path/to/the/file.pdf');
```

### Generate a pdf document from a twig view

```php
$this->get('knp_snappy.pdf')->generateFromHtml(
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

class SomeController
{
    public function imageAction()
    {
        $html = $this->renderView('MyBundle:Foo:bar.html.twig', array(
            'some'  => $vars
        ));

        return new JpegResponse(
            $this->get('knp_snappy.image')->getOutputFromHtml($html),
            'image.jpg'
        );
    }
}
```

### Render a pdf document as response from a controller

```php
use Knp\Bundle\SnappyBundle\Snappy\Response\PdfResponse;

class SomeController extends Controller
{
    public function pdfAction()
    {
        $html = $this->renderView('MyBundle:Foo:bar.html.twig', array(
            'some'  => $vars
        ));

        return new PdfResponse(
            $this->get('knp_snappy.pdf')->getOutputFromHtml($html),
            'file.pdf'
        );
    }
}
```

### Render a pdf document with a relative url inside like css files

```php
use Knp\Bundle\SnappyBundle\Snappy\Response\PdfResponse;

class SomeController extends Controller
{
    public function pdfAction()
    {
        $pageUrl = $this->generateUrl('homepage', array(), true); // use absolute path!

        return new PdfResponse(
            $this->get('knp_snappy.pdf')->getOutput($html),
            'file.pdf'
        );
    }
}
```

Credits
-------

SnappyBundle and [Snappy][snappy] are based on the awesome [wkhtmltopdf][wkhtmltopdf].
SnappyBundle has been developed by [KnpLabs][KnpLabs].

[snappy]: https://github.com/KnpLabs/snappy
[wkhtmltopdf]: http://wkhtmltopdf.org
[KnpLabs]: http://www.knplabs.com
