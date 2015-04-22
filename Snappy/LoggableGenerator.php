<?php

namespace Knp\Bundle\SnappyBundle\Snappy;

use Knp\Snappy\GeneratorInterface;
use Symfony\Component\HttpKernel\Log\LoggerInterface;

/**
 * Wraps a GeneratorInterface instance to log the media generations using the
 * configured logger.
 */
class LoggableGenerator implements GeneratorInterface
{
    private $generator;
    private $logger;

    /**
     * Constructor
     *
     * @param GeneratorInterface $generator
     * @param LoggerInterface    $logger
     */
    public function __construct(GeneratorInterface $generator, LoggerInterface $logger = null)
    {
        $this->generator = $generator;
        $this->logger = $logger;
    }

    /**
     * Returns the underlying generator instance
     *
     * @return GeneratorInterface
     */
    public function getInternalGenerator()
    {
        return $this->generator;
    }

    /**
     * {@inheritDoc}
     */
    public function generate($input, $output, array $options = array(), $overwrite = false)
    {
        if (is_array($input)) {
            $debug_input = implode(", ", $input);
        } else {
            $debug_input = $input;
        }
        $this->logDebug(sprintf('Generate from file (%s) to file (%s).', $debug_input, $output));

        $this->generator->generate($input, $output, $options, $overwrite);
    }

    /**
     * {@inheritDoc}
     */
    public function generateFromHtml($html, $output, array $options = array(), $overwrite = false)
    {
        $debugHtml = is_array($html) ? implode(', ', $html) : $html;

        $this->logDebug(sprintf('Generate from HTML (%s) to file (%s).', substr($debugHtml, 0, 100), $output));

        $this->generator->generateFromHtml($html, $output, $options, $overwrite);
    }

    /**
     * {@inheritDoc}
     */
    public function getOutput($input, array $options = array())
    {
        if (is_array($input)) {
            $debug_input = implode(", ", $input);
        } else {
            $debug_input = $input;
        }
        $this->logDebug(sprintf('Output from file (%s).', $debug_input));

        return $this->generator->getOutput($input, $options);
    }

    /**
     * {@inheritDoc}
     */
    public function getOutputFromHtml($html, array $options = array())
    {
        $debugHtml = is_array($html) ? implode(', ', $html) : $html;

        $this->logDebug(sprintf('Output from HTML (%s).', substr($debugHtml, 0, 100)));

        return $this->generator->getOutputFromHtml($html, $options);
    }

    /**
     * {@inheritDoc}
     */
    public function setOption($name, $value)
    {
        $this->logDebug(sprintf('Set option %s = %s.', $name, var_export($value, true)));

        return $this->generator->setOption($name, $value);
    }

    /**
     * Logs the given debug message if the logger is configured or do nothing
     * otherwise
     *
     * @param string $message
     */
    private function logDebug($message)
    {
        if (null === $this->logger) {
            return;
        }

        $this->logger->debug($message);
    }
}
