<?php

namespace Bug\DoctrineListenerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class MapController extends Controller
{
    public function mapAction(Request $request)
    {
        // init
        $ms = $this->get('doctrine_listener_bundle.map_service');
        $address = $request->query->get('address', null);
        $locs = array();
        $map = null;
        if (!$request->query->has('nomap')) {
            if ($address) {
                $locs = array_merge(array(), $ms->fromString($address));
            }
            $map = $ms->createMap($locs, true, true);
        }

        return $this->render(
            'DoctrineListenerBundle:Map:map.html.twig',
            array(
                'address' => $address,
                'locs' => $locs,
                'map' => $map,
            )
        );
    }
}
