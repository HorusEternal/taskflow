<?php

namespace App\EventListener;

use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use Symfony\Component\HttpKernel\Event\RequestEvent;

final class ApiVersionListener
{
    #[AsEventListener]
    public function onKernelRequest(RequestEvent $event): void
    {
        $request = $event->getRequest();
        $accept = $request->headers->get('Accept', '');
        if (preg_match('#application/vnd\.taskflow\.v(?P<version>\d+)\+json#', $accept, $matches)) {
            $request->attributes->set('api_version', 'v' . $matches['version']);
        } else {
            $path = $request->getPathInfo();
            if (preg_match('#^/api/v(?P<version>\d+)#', $path, $matches)) {
                $request->attributes->set('api_version', $matches['version']);
            } else {
                $request->attributes->set('api_version', 'v1');
            }
        }
    }
}
