<?php

namespace Bug\DoctrineListenerBundle\Service;

use Doctrine\ORM\Events;
use Ivory\GoogleMap\Events\Event;
use Ivory\GoogleMap\Map;
use Ivory\GoogleMap\Overlays\Animation;
use Ivory\GoogleMap\Overlays\Circle;
use Ivory\GoogleMap\Overlays\InfoWindow;
use Ivory\GoogleMap\Overlays\Marker;
use Ivory\GoogleMap\Overlays\Rectangle;
use Ivory\GoogleMap\Services\Geocoding\Geocoder;
use Ivory\GoogleMap\Services\Geocoding\Result\GeocoderResult;

class MapService
{
    // MEMBERS

    /**
     * @var Geocoder
     */
    protected $geocoder;

    // SPECIAL

    /**
     * @param Geocoder $gc
     */
    public function __construct(Geocoder $gc)
    {
        $this->geocoder = $gc;
    }

    // METHODS

    /**
     * @param $locs
     * @param bool $with_picker
     * @param bool $with_rect
     * @return Map
     */
    public function createMap($locs, $with_picker = false, $with_rect = false)
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

        foreach ($locs as $loc) {
            $info = new InfoWindow();
            $info->setContent($loc->getFormattedAddress());
            $info->setOpen(false);
            $info->setAutoOpen(true);
            $info->setAutoClose(true);

            $marker = new Marker();
            $marker->setPosition($loc->getGeometry()->getLocation());
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

        if ($with_picker) {
            $picker = new Marker();
            $picker->setJavascriptVariable('marker_picker');
            $picker->setAnimation(Animation::DROP);
            $picker->setPosition(52.5233, 13.4127, true); # BERLIN
            $picker->setOption('draggable', true);
            $picker->setOption('title', 'Drag me!');

            // dragging event listeners
            $drag = new Event();
            $drag->setInstance($picker->getJavascriptVariable());
            $drag->setEventName('drag');
            $drag->setHandle('function(event){updateMarkerStatus("Dragging...");updateMarkerPosition(marker_picker.getPosition());updateMarkerCircle();}');
            $map->getEventManager()->addEvent($drag);
            $drag_end = new Event();
            $drag_end->setInstance($picker->getJavascriptVariable());
            $drag_end->setEventName('dragend');
            $drag_end->setHandle('function(){updateMarkerStatus("Stationary..");updateAddress();}');
            $map->getEventManager()->addEvent($drag_end);
            $drag_end = new Event();

            $circle = new Circle();
            $circle->setJavascriptVariable('circle_picker');
            $circle->setCenter($picker->getPosition());
            $circle->setRadius(50000); # 50km
            $circle->setOption('clickable', false);
            $circle->setOption('strokeWeight', 2);

            $map->addMarker($picker);
            $map->addCircle($circle);
        }

        return $map;
    }

    /**
     * @param $str
     * @return array
     */
    public function fromString($str)
    {
        $rsp = $this->geocoder->geocode($str);
        return $rsp->getResults();
    }

    /**
     * @param $loc
     * @return array
     */
    public function geocodeFromLocation($loc)
    {
        $rsp = $this->geocoder->reverse($loc->getLatitude(), $loc->getLongitude());
        return $rsp->getResults();
    }
}
