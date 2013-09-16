<?php

namespace Bug\DoctrineListenerBundle\Controller;

use Ivory\GoogleMap\Map;
use Ivory\GoogleMap\Overlays\InfoWindow;
use Ivory\GoogleMap\Overlays\Marker;
use Ivory\GoogleMap\Overlays\Rectangle;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Generator\UrlGenerator;
use Symfony\Component\Routing\Router;

class DefaultController extends Controller
{
    public function indexAction($name = null)
    {
        return $this->render(
            'DoctrineListenerBundle::index.html.twig',
            array(
                'name' => $name,
                'gmap' => $this->createMap(true, true),
            )
        );
    }

    public function createMap($with_berlin = false, $with_rect = false)
    {
        $map = new Map();
        $map->setMapOption('mapTypeId', 'hybrid');
        $map->setAsync(true);
        $map->setAutoZoom(true);
        $map->setCenter(52.5233, 13.4127, true); # BERLIN
        $map->setMapOption('zoom', 8);
        $map->setStylesheetOption('width', '450px');
        $map->setStylesheetOption('height', '450px');
        $map->setLanguage('de');

        if ($with_berlin) {
            $info = new InfoWindow();
            $info->setContent('Berlin - The good stuff happens here!');
            $info->setOpen(false);
            $info->setAutoOpen(true);
            $info->setAutoClose(true);

            $marker = new Marker();
            $marker->setPosition(52.5233, 13.4127, true);
            $marker->setInfoWindow($info);

            $map->addMarker($marker);
        }
        if ($with_rect) {
            $rectangle = new Rectangle();
            $rectangle->setBound(47.270210, 5.866240, 55.058140, 15.042050, true, true);
            $rectangle->setOption('clickable', false);
            $rectangle->setOption('strokeColor', '#ffffff');
            $rectangle->setOption('fillOpacity', 0.0);
            $map->addRectangle($rectangle);
        }

        return $map;
    }
}
