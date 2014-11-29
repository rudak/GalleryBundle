<?php

namespace Rudak\GalleryBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Rudak\GalleryBundle\Entity\Picture;
use Rudak\GalleryBundle\Form\PictureType;

/**
 * Picture controller.
 *
 */
class PictureController extends Controller
{

    /**
     * Lists all Picture entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('RudakGalleryBundle:Picture')->getPicturesListAdmin();

        return $this->render('RudakGalleryBundle:Picture:index.html.twig', array(
            'entities' => $entities,
        ));
    }

    /**
     * Creates a new Picture entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new Picture();
        $form   = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('admin_gallery_picture_show', array('id' => $entity->getId())));
        }

        return $this->render('RudakGalleryBundle:Picture:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a Picture entity.
     *
     * @param Picture $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Picture $entity)
    {
        $form = $this->createForm(new PictureType(), $entity, array(
            'action' => $this->generateUrl('admin_gallery_picture_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array(
            'label' => 'Ajouter',
            'attr'  => array(
                'class' => 'btn btn-success'
            )
        ));

        return $form;
    }

    /**
     * Displays a form to create a new Picture entity.
     *
     */
    public function newAction()
    {
        $entity = new Picture();
        $form   = $this->createCreateForm($entity);

        return $this->render('RudakGalleryBundle:Picture:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Picture entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('RudakGalleryBundle:Picture')->getPicturesByIdAdmin($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Picture entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('RudakGalleryBundle:Picture:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Picture entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('RudakGalleryBundle:Picture')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Picture entity.');
        }

        $editForm   = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('RudakGalleryBundle:Picture:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Creates a form to edit a Picture entity.
     *
     * @param Picture $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(Picture $entity)
    {
        $form = $this->createForm(new PictureType(), $entity, array(
            'action' => $this->generateUrl('admin_gallery_picture_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array(
            'label' => 'Modifier',
            'attr'  => array(
                'class' => 'btn btn-warning'
            )));

        return $form;
    }

    /**
     * Edits an existing Picture entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('RudakGalleryBundle:Picture')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Picture entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm   = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('admin_gallery_picture_edit', array('id' => $id)));
        }

        return $this->render('RudakGalleryBundle:Picture:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Picture entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em     = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('RudakGalleryBundle:Picture')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Picture entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('admin_gallery_picture'));
    }

    /**
     * Creates a form to delete a Picture entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_gallery_picture_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array(
                'label' => 'Supprimer',
                'attr'  => array(
                    'class' => 'btn btn-danger'
                )))
            ->getForm();
    }
}
