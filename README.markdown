Provide HTML to PDF/image to your Symfony2 projects.

## Installation

Download SnappyBundle in your `vendor/bundles/Knp/Bundle/SnappyBundle` dir.

    git submodule add https://github.com/knplabs/SnappyBundle.git vendor/bundles/Knp/Bundle/SnappyBundle

Enable it in your `app/AppKernel.php`:

    public function registerBundles()
    {
        $bundles = array(
            ...
            new Knp\Bundle\SnappyBundle\KnpSnappyBundle(),
            ...

And in your `autoload.php`:

    $loader->registerNamespaces(array(
        ...
        'Knp'                        => array(__DIR__.'/../src', __DIR__.'/../vendor/bundles', __DIR__.'/../vendor'),
    
    
Then, enable it in your `app/config.yml`:

    knp_snappy:
        image: ~      # Enable the snappy html to image service
        pdf: ~        # Enable the snappy pdf to image service
    
    parameters:
        knp.snappy.pdf.executable: /usr/local/bin/wkhtmltopdf
        knp.snappy.image.executable: /usr/local/bin/wkhtmltoimage

## Requirements

You should have [Snappy](http://github.com/knplabs/snappy) (php5.3 branch) installed in your `vendor` dir and registered in your autoload.

### Snappy

Download Snappy in `vendor/knp-snappy/snappy`:

    git submodule add http://github.com/knplabs/snappy.git vendor/knp-snappy

And edit your `app/autoload.php`:

    $loader->registerNamespaces(array(
        ...
        'Knp\\Snappy'                => __DIR__.'/../vendor/knp-snappy/src',

### wkhtmltopdf

You also need the wkhtmltopdf and wkhtmltoimage executables provided by [wkhtmltopdf](http://code.google.com/p/wkhtmltopdf/).

## Usage

To save a screenshot of an url:

    $this->container->get('knp_snappy_image')->save('http://www.google.fr', '/tmp/a.jpg');

To create a pdf in your controller:

    return new Response(
        $this->container->get('knp_snappy_pdf')->get('http://www.google.fr'),
        200,
        array(
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'attachment; filename="file.pdf',
        )
    );

To output an image in your controller:

    return new Response(
        $this->container->get('knp_snappy_image')->get('http://www.google.fr'),
        200,
        array(
            'Content-Type' => 'image/jpg',
            'Content-Disposition' => 'filename="bla.jpg',
        )
    );

You can also transform YOUR html into image or PDF:

    $html = '<html><body><h1>Hello Knp Labs</h1><h2>So now what?</h2>';
    return new Response(
        $this->container->get('knp_snappy_image')->get($html),
        200,
        array(
            'Content-Type' => 'image/jpg',
            'Content-Disposition' => 'filename="bla.jpg',
        )
    );

Or better:

    $html = $this->container->get('templating')->render('KnpCorporate:Front:index.html.twig', array('title' => 'lorem'));
    return new Response(
        $this->get('knp_snappy_image')->get($html),
        200,
        array(
            'Content-Type' => 'image/jpg',
            'Content-Disposition' => 'filename="bla.jpg',
        )
    );
    
Don't forget to use absolute urls!

## Credits

SnappyBundle and Snappy are based on the awesome wkhtmltopdf.
SnappyBundle has been developed by Knp Labs, our [Symfony2 webagency](http://www.knplabs.com).

