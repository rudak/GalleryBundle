<?php

namespace Rudak\GalleryBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Rudak\GalleryBundle\Entity\Gallery;
use Rudak\GalleryBundle\Form\GalleryType;

/**
 * Gallery controller.
 *
 */
class GalleryController extends Controller
{

    /**
     * Lists all Gallery entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('RudakGalleryBundle:Gallery')->getAllGalleriesForIndex();

        return $this->render('RudakGalleryBundle:Gallery:index.html.twig', array(
            'entities' => $entities,
        ));
    }

    /**
     * Creates a new Gallery entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new Gallery();
        $entity->setDate(new \Datetime('NOW'));
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();
            $this->get('session')->getFlashBag()->add(
                'success',
                'Galerie créée avec succès !'
            );

            $this->logging($this->getUser()->getUsername(), sprintf('Création d\'une galerie [#%d]', $entity->getId()), 'Gallery');


            return $this->redirect($this->generateUrl('admin_gallery_show', array('id' => $entity->getId())));
        }

        return $this->render('RudakGalleryBundle:Gallery:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a Gallery entity.
     *
     * @param Gallery $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Gallery $entity)
    {
        $form = $this->createForm(new GalleryType(), $entity, array(
            'action' => $this->generateUrl('admin_gallery_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array(
            'label' => 'Ajouter',
            'attr'  => array(
                'class' => 'btn btn-success'
            )));

        return $form;
    }

    /**
     * Displays a form to create a new Gallery entity.
     *
     */
    public function newAction()
    {
        $entity = new Gallery();
        $form   = $this->createCreateForm($entity);

        return $this->render('RudakGalleryBundle:Gallery:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Gallery entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('RudakGalleryBundle:Gallery')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Gallery entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('RudakGalleryBundle:Gallery:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Gallery entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('RudakGalleryBundle:Gallery')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Gallery entity.');
        }

        $editForm   = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('RudakGalleryBundle:Gallery:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Creates a form to edit a Gallery entity.
     *
     * @param Gallery $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(Gallery $entity)
    {
        $form = $this->createForm(new GalleryType(), $entity, array(
            'action' => $this->generateUrl('admin_gallery_update', array('id' => $entity->getId())),
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
     * Edits an existing Gallery entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('RudakGalleryBundle:Gallery')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Gallery entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm   = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {

            $this->logging($this->getUser()->getUsername(), sprintf('Modification d\'une galerie [#%d]', $entity->getId()), 'Gallery');

            $em->flush();
            $this->get('session')->getFlashBag()->add(
                'success',
                'Modifiée avec succès !'
            );
            return $this->redirect($this->generateUrl('admin_gallery_edit', array('id' => $id)));
        }

        return $this->render('RudakGalleryBundle:Gallery:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Gallery entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em     = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('RudakGalleryBundle:Gallery')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Gallery entity.');
            }

            $this->logging($this->getUser()->getUsername(), sprintf('Suppression d\'une galerie [#%d]', $entity->getId()), 'Gallery');

            $em->remove($entity);
            $em->flush();
            $this->get('session')->getFlashBag()->add(
                'success',
                'Galerie supprimée avec succès !'
            );
        }

        return $this->redirect($this->generateUrl('admin_gallery'));
    }

    /**
     * Creates a form to delete a Gallery entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_gallery_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array(
                'label' => 'Supprimer',
                'attr'  => array(
                    'class' => 'btn btn-danger'
                )))
            ->getForm();
    }

    private function logging($user, $action, $category)
    {
        try {
            $OwnLogger = $this->get('rudak.own.logger');
            $OwnLogger->addEntry($user, $action, $category, new \DateTime());
        } catch (\Exception $e) {
        }
    }
}
