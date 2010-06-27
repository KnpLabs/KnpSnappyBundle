Provide HTML to PDF/image to your Symfony2 projects.

## Installation

Put SnappyBundle to your src/Bundle dir.

Then, enable it in your config.yml:

    snappy.image: ~      # Enable the snappy html to image service
    snappy.pdf: ~        # Enable the snappy pdf to image service

## Requirements

You should have [Snappy](http://github.com/knplabs/snappy) (php5.3 branch) installed in your src/vendor dir and registered in your autoload.
You also need the wkhtmltopdf and wkhtmltoimage executables provided by wkhtmltopdf.

## Usage

    $content = $this->container->snappyPdf->output('http://www.google.fr', true);
    $content = $this->container->snappyImage->output('http://www.google.fr', true);

## Credits

SnappyBundle and Snappy are based on the awesome wkhtmltopdf.
SnappyBundle has been developed by knpLabs, our [Symfony2 webagency](http://www.knplabs.com).

