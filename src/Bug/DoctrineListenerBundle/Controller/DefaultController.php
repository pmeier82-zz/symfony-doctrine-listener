<?php

namespace Bug\DoctrineListenerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name = null)
    {
        $form = $this->createFormBuilder()
            ->add('text', 'ckeditor')
            ->getForm();
        return $this->render(
            'DoctrineListenerBundle::index.html.twig',
            array(
                'name' => $name,
                'form' => $form->createView(),
            )
        );
    }
}
