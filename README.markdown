KnpSnappyBundle
===============

[Snappy][snappy] is a PHP (5.3+) wrapper for the [wkhtmltopdf][wkhtmltopdf] conversion utility.
It allows you to generate either pdf or image files from your html documents, using the webkit engine.

The KnpSnappyBundle provides a simple integration for your Symfony project.

Installation
------------

*The commands accompanying each step assume that you are versioning your project using git and you manage your vendors as submodules.
If not you can ignore them.*

First, you must copy the [Snappy][snappy] source in the `vendor/snappy` directory of your project:

    git submodule add https://github.com/knplabs/snappy.git vendor/snappy

And the KnpSnappyBundle source in the `vendor/bundles/Knp/Bundle/SnappyBundle` directory:

    git submodule add https://github.com/knplabs/SnappyBundle.git vendor/bundles/Knp/Bundle/SnappyBundle

Then, you can register both source directories in your autoloader:

    $loader->registerNamespaces(array(
        ...
        'Knp'                        => __DIR__.'/../vendor/bundles',
        'Knp\\Snappy'                => __DIR__.'/../vendor/snappy/src',

Finally, you can enable it in your kernel:

    // app/AppKernel.php
    public function registerBundles()
    {
        $bundles = array(
            ...
            new Knp\Bundle\SnappyBundle\KnpSnappyBundle(),
            ...

Configuration
-------------

If you need to change the binaries, change the instance options or even disable one or both services, you can do it through the configuration.

    # app/config/config.yml
    knp_snappy:
        pdf:
            enabled:    true
            binary:     /usr/local/bin/wkhtmltopdf
            options:    []
        image:
            enabled:    true
            binary:     /usr/local/bin/wkhtmltoimage
            options:    []

Usage
-----

The bundle registers two services:

 - the `knp_snappy.image` service allows you to generate images;
 - the `knp_snappy.pdf` service allows you to generate pdf files.

### Generate an image from an URL

    $container->get('knp_snappy.image')->generate('http://www.google.fr', '/path/to/the/image.jpg');

### Generate a pdf document from an URL

    $container->get('knp_snappy.pdf')->generate('http://www.google.fr', '/path/to/the/file.pdf');

### Render an image as response from a controller

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

### Render a pdf document as response from a controller

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

Credits
-------

SnappyBundle and [Snappy][snappy] are based on the awesome [wkhtmltopdf][wkhtmltopdf].
SnappyBundle has been developed by [Knp Labs][knplabs].

[snappy]: https://github.com/knplabs/snappy
[wkhtmltopdf]: http://code.google.com/p/wkhtmltopdf/
[knplabs]: http://www.knplabs.com
