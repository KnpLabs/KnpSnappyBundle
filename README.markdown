KnpSnappyBundle
===============

[Snappy][snappy] is a PHP (5.3+) wrapper for the [wkhtmltopdf][wkhtmltopdf] conversion utility.
It allows you to generate either pdf or image files from your html documents, using the webkit engine.

The KnpSnappyBundle provides a simple integration for your Symfony project.

[![knpbundles.com](http://knpbundles.com/KnpLabs/KnpSnappyBundle/badge-short)](http://knpbundles.com/KnpLabs/KnpSnappyBundle)

Installation
------------

With [composer](http://packagist.org), add:

    {
        require: {
            "knplabs/knp-snappy-bundle": "dev-master"
        }
    }

Or use `deps` file:
    
    [snappy]
        git=https://github.com/KnpLabs/snappy.git
        target=snappy

    [KnpSnappyBundle]
        git=https://github.com/KnpLabs/KnpSnappyBundle.git
        target=/bundles/Knp/Bundle/SnappyBundle

Or define as submodules:

    # Install snappy library
    git submodule add https://github.com/KnpLabs/snappy.git vendor/snappy
    
    # Install bundle
    git submodule add https://github.com/KnpLabs/KnpSnappyBundle.git vendor/bundles/Knp/Bundle/SnappyBundle
    
Or just clone the repos:
    
    # Install snappy library
    git clone https://github.com/KnpLabs/snappy.git vendor/snappy

    # Install bundle
    git clone https://github.com/KnpLabs/KnpSnappyBundle.git vendor/bundles/Knp/Bundle/SnappyBundle


Then, you should register both source directories in your autoloader unless you are using [composer](http://packagist.org):

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
    
### Render a pdf document with a relative url inside like css files

    $pageUrl = $this->generateUrl('homepage', array(), true); // use absolute path!
    
    return new Response(
        $this->get('knp_snappy.pdf')->getOutput($pageUrl),
        200,
        array(
            'Content-Type'          => 'application/pdf',
            'Content-Disposition'   => 'attachment; filename="file.pdf"'
        )
    );

Credits
-------

SnappyBundle and [Snappy][snappy] are based on the awesome [wkhtmltopdf][wkhtmltopdf].
SnappyBundle has been developed by [KnpLabs][KnpLabs].

[snappy]: https://github.com/KnpLabs/snappy
[wkhtmltopdf]: http://code.google.com/p/wkhtmltopdf/
[KnpLabs]: http://www.knplabs.com
