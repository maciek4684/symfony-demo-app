<?php


namespace App\EventListener;

use Symfony\Component\HttpKernel\Event\RequestEvent;

final class AppLocaleListener
{

    public function onKernelRequest(RequestEvent $event)
    {
        $request = $event->getRequest();

        $lang = $request->headers->get('Accept-Language');

        if($lang != null)
        {
            $request->setLocale($lang);
        }
    }
}
