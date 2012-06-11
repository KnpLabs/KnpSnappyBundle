<?php

/*
 * Copyright 2011 Piotr Śliwa <peter.pl7@gmail.com>
 *
 * License information is in LICENSE file
 */

namespace Knp\Bundle\SnappyBundle\EventListener;

use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;
use Symfony\Component\HttpKernel\Event\FilterResponseEvent;

use Knp\Bundle\SnappyBundle\Annotation\AbstractAnnotation;
use Symfony\Component\HttpFoundation\Response;

use Knp\Snappy\GeneratorInterface;
use Doctrine\Common\Annotations\Reader;

/**
 * This listener will replace reponse content by pdf document's content if Pdf annotations is found.
 * Also adds pdf format to request object and adds proper headers to response object.
 * 
 * @author Piotr Śliwa <peter.pl7@gmail.com>
 */
class PdfListener
{
    private $snappy;
    private $reader;
    
    public function __construct(GeneratorInterface $snappy, Reader $reader)
    {
        $this->snappy = $snappy;
        $this->reader = $reader;
    }
    
    public function onKernelRequest(GetResponseEvent $event)
    {
        $request = $event->getRequest();
    }
    
    public function onKernelController(FilterControllerEvent $event)
    {
        if (!is_array($controller = $event->getController())) {
            return;
        }

        $object = new \ReflectionObject($controller[0]);
        $method = $object->getMethod($controller[1]);

        $request = $event->getRequest();
        foreach ($this->reader->getMethodAnnotations($method) as $configuration) {
            if ($configuration instanceof AbstractAnnotation) {
                $request->attributes->set('_'.$configuration->getAliasName(), $configuration);
            }
        }
    }
    
    public function onKernelResponse(FilterResponseEvent $event)
    {
		$request = $event->getRequest();
		$response = $event->getResponse();
		
		if(
			$request->getRequestFormat() == 'pdf' and
			$response->getStatusCode() == 200 and
			(!($annotation = $request->get('_snappyPDF')) or $annotation->isActive())
		)
		{
			$content = $this->snappy->getOutputFromHtml($response->getContent());
			
			$headers = array(
				'Content-Length'      => strlen($content),
				'Content-Type'        => 'application/pdf',
				'Content-Disposition' => $annotation->getDisposition(),
			);
			foreach($headers as $key => $value)
				$response->headers->set($key, $value);
			
			$response->setContent($content);
		}
    }
}