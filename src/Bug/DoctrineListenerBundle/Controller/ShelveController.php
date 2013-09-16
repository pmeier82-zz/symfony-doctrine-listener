<?php

namespace Bug\DoctrineListenerBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Bug\DoctrineListenerBundle\Entity\Shelve;
use Bug\DoctrineListenerBundle\Form\ShelveType;

/**
 * Shelve controller.
 *
 */
class ShelveController extends Controller
{

    /**
     * Lists all Shelve entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('DoctrineListenerBundle:Shelve')->findAll();

        return $this->render('DoctrineListenerBundle:Shelve:index.html.twig', array(
            'entities' => $entities,
        ));
    }
    /**
     * Creates a new Shelve entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new Shelve();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('shelve_show', array('id' => $entity->getId())));
        }

        return $this->render('DoctrineListenerBundle:Shelve:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
    * Creates a form to create a Shelve entity.
    *
    * @param Shelve $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createCreateForm(Shelve $entity)
    {
        $form = $this->createForm(new ShelveType(), $entity, array(
            'action' => $this->generateUrl('shelve_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Shelve entity.
     *
     */
    public function newAction()
    {
        $entity = new Shelve();
        $form   = $this->createCreateForm($entity);

        return $this->render('DoctrineListenerBundle:Shelve:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Shelve entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('DoctrineListenerBundle:Shelve')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Shelve entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('DoctrineListenerBundle:Shelve:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),        ));
    }

    /**
     * Displays a form to edit an existing Shelve entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('DoctrineListenerBundle:Shelve')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Shelve entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('DoctrineListenerBundle:Shelve:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a Shelve entity.
    *
    * @param Shelve $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Shelve $entity)
    {
        $form = $this->createForm(new ShelveType(), $entity, array(
            'action' => $this->generateUrl('shelve_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Shelve entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('DoctrineListenerBundle:Shelve')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Shelve entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('shelve_edit', array('id' => $id)));
        }

        return $this->render('DoctrineListenerBundle:Shelve:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a Shelve entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('DoctrineListenerBundle:Shelve')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Shelve entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('shelve'));
    }

    /**
     * Creates a form to delete a Shelve entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('shelve_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
