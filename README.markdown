KnpSnappyBundle
===============

[Snappy][snappy] is a PHP (5.3+) wrapper for the [wkhtmltopdf][wkhtmltopdf] conversion utility.
It allows you to generate either pdf or image files from your html documents, using the webkit engine.

The KnpSnappyBundle provides a simple integration for your Symfony project.

[![Build Status](https://secure.travis-ci.org/KnpLabs/KnpSnappyBundle.png)](http://travis-ci.org/KnpLabs/KnpSnappyBundle)

[![knpbundles.com](http://knpbundles.com/KnpLabs/KnpSnappyBundle/badge-short)](http://knpbundles.com/KnpLabs/KnpSnappyBundle)

Installation
------------

With [composer](http://packagist.org), add:

```json
{
    "require": {
        "knplabs/knp-snappy-bundle": "~1.4"
    }
}
```

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
    temporary_folder: %kernel.cache_dir%/snappy
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
$html = $this->renderView('MyBundle:Foo:bar.html.twig', array(
    'some'  => $vars
));


return new Response(
    $this->get('knp_snappy.image')->getOutputFromHtml($html),
    200,
    array(
        'Content-Type'          => 'image/jpg',
        'Content-Disposition'   => 'filename="image.jpg"'
    )
);
```

### Render a pdf document as response from a controller

```php
$html = $this->renderView('MyBundle:Foo:bar.html.twig', array(
    'some'  => $vars
));

return new Response(
    $this->get('knp_snappy.pdf')->getOutputFromHtml($html),
    200,
    array(
        'Content-Type'          => 'application/pdf',
        'Content-Disposition'   => 'attachment; filename="file.pdf"'
    )
);
```

### Render a pdf document with a relative url inside like css files

```php
$pageUrl = $this->generateUrl('homepage', array(), true); // use absolute path!

return new Response(
    $this->get('knp_snappy.pdf')->getOutput($pageUrl),
    200,
    array(
        'Content-Type'          => 'application/pdf',
        'Content-Disposition'   => 'attachment; filename="file.pdf"'
    )
);
```
Silex ~2.0@dev configuration
----------------------------
### ServiceProvider file

```
namespace Acme\Snappy;

use Pimple\Container;
use Pimple\ServiceProviderInterface;
use Silex\Application;
use Knp\Snappy\Pdf;
use Knp\Snappy\Image;
/**
 * Snappy library Provider.
 *
 */
class SnappyServiceProvider implements ServiceProviderInterface
{
    /**
     * @param Application $app
     */
    public function register(Container $app)
    {
        $app['snappy.image'] = function ($app) {
            return new Image(
                isset($app['snappy.image.binary']) ? $app['snappy.image.binary'] : '/usr/local/bin/wkhtmltoimage',
                isset($app['snappy.image.options']) ? $app['snappy.image.options'] : array()
            );
        };
        $app['snappy.pdf'] = function ($app) {
            return new Pdf(
                isset($app['snappy.pdf.binary']) ? $app['snappy.pdf.binary'] : '/usr/local/bin/wkhtmltopdf',
                isset($app['snappy.pdf.options']) ? $app['snappy.pdf.options'] : array()
            );
        };
    }
    /**
     * @param Application $app
     */
    public function boot(Application $app)
    {
    }
}
```

### app.php registration

```
$app->register(new SnappyServiceProvider());
```

Credits
-------

SnappyBundle and [Snappy][snappy] are based on the awesome [wkhtmltopdf][wkhtmltopdf].
SnappyBundle has been developed by [KnpLabs][KnpLabs].

[snappy]: https://github.com/KnpLabs/snappy
[wkhtmltopdf]: http://wkhtmltopdf.org
[KnpLabs]: http://www.knplabs.com
