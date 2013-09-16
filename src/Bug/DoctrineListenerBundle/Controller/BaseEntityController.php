<?php

namespace Bug\DoctrineListenerBundle\Controller;

use Bug\DoctrineListenerBundle\Entity\Base;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

abstract class BaseEntityController
    extends Controller
{
    // CONSTANTS

    const BUNDLE = 'DoctrineListenerBundle';
    const ENTITY = null;

    // MEMBERS

    /**
     * @var string
     */
    protected $str_entity = null;

    /**
     * @var \ReflectionClass
     */
    protected $cls_entity = null;

    /**
     * @var \ReflectionClass
     */
    protected $cls_form = null;


    // SPECIAL

    public function __construct()
    {
        if (!is_string($this::ENTITY) || !is_string($this::BUNDLE)) {
            throw new \Exception('Bad controller definition!');
        }
        $this->str_entity = $this::BUNDLE . ':' . $this::ENTITY;
        $this->cls_entity = new \ReflectionClass('Bug\\' . $this::BUNDLE . '\\Entity\\' . $this::ENTITY);
        $this->cls_form = new \ReflectionClass('Bug\\' . $this::BUNDLE . '\\Form\\' . $this::ENTITY . 'Type');
    }

    // METHODS

    /**
     * Lists all Item entities.
     */
    public function indexAction()
    {
        $entities = $this->get('knp_paginator')->paginate(
            $this->getDoctrine()->getRepository($this->str_entity)->findAll(),
            $this->getRequest()->query->get('page', 1),
            $this->getRequest()->query->get('page_max', 5)
        );

        return $this->render(
            $this->str_entity . ':index.html.twig',
            array(
                'entities' => $entities,
            )
        );
    }

    /**
     * Creates a new entity.
     */
    public function createAction(Request $request)
    {
        $entity = $this->cls_entity->newInstance();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect(
                $this->generateUrl(
                    strtolower($this::ENTITY) . '_show',
                    array('id' => $entity->getId()
                    )
                )
            );
        }

        return $this->render(
            $this->str_entity . ':new.html.twig',
            array(
                'entity' => $entity,
                'form' => $form->createView(),
            )
        );
    }

    /**
     * @param Base $entity
     * @return \Symfony\Component\Form\Form
     */
    private function createCreateForm(Base $entity)
    {
        $form = $this->createForm($this->cls_form->newInstance(), $entity, array(
            'action' => $this->generateUrl(strtolower($this::ENTITY) . '_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new entity.
     */
    public function newAction()
    {
        $entity = $this->cls_entity->newInstance();
        $form = $this->createCreateForm($entity);

        return $this->render(
            $this->str_entity . ':new.html.twig',
            array(
                'entity' => $entity,
                'form' => $form->createView(),
            )
        );
    }

    /**
     * Finds and displays an entity.
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->find($this->str_entity, $id);
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find ' . $this::ENTITY . ' entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render(
            $this->str_entity . ':show.html.twig',
            array(
                'entity' => $entity,
                'delete_form' => $deleteForm->createView(),
            )
        );
    }

    /**
     * Displays a form to edit an existing entity.
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->find($this->str_entity, $id);
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find ' . $this::ENTITY . ' entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render(
            $this->str_entity . ':edit.html.twig',
            array(
                'entity' => $entity,
                'edit_form' => $editForm->createView(),
                'delete_form' => $deleteForm->createView(),
            )
        );
    }

    /**
     * Creates a form to edit an entity.
     * @param Base $entity
     * @return \Symfony\Component\Form\Form
     */
    private function createEditForm(Base $entity)
    {
        $form = $this->createForm($this->cls_form->newInstance(), $entity, array(
            'action' => $this->generateUrl(strtolower($this::ENTITY) . '_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }

    /**
     * Edits an existing entity.
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->find($this->str_entity, $id);
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find ' . $this::ENTITY . ' entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl(strtolower($this::ENTITY) . '_edit', array('id' => $id)));
        }

        return $this->render(
            $this->str_entity . ':edit.html.twig',
            array(
                'entity' => $entity,
                'edit_form' => $editForm->createView(),
                'delete_form' => $deleteForm->createView(),
            )
        );
    }

    /**
     * Deletes a entity.
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->find($this->str_entity, $id);
            if (!$entity) {
                throw $this->createNotFoundException('Unable to find ' . $this::ENTITY . ' entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl(strtolower($this::ENTITY)));
    }

    /**
     * Creates a form to delete an entity by id.
     * @param $id
     * @return \Symfony\Component\Form\Form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl(strtolower($this::ENTITY) . '_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm();
    }
}
