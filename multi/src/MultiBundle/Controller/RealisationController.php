<?php

namespace MultiBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use MultiBundle\Entity\Realisation;
use MultiBundle\Form\RealisationType;

/**
 * Realisation controller.
 *
 */
class RealisationController extends Controller
{
    /**
     * Lists all Realisation entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $realisations = $em->getRepository('MultiBundle:Realisation')->findAll();

        return $this->render('MultiBundle:realisation:index.html.twig', array(
            'realisations' => $realisations,
        ));
    }

    /**
     * Creates a new Realisation entity.
     *
     */
    public function newAction(Request $request)
    {
        $realisation = new Realisation();
        $form = $this->createForm('MultiBundle\Form\RealisationType', $realisation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($realisation);
            $em->flush();

            return $this->redirectToRoute('realisation_show', array('id' => $realisation->getId()));
        }

        return $this->render('MultiBundle:realisation:new.html.twig', array(
            'realisation' => $realisation,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Realisation entity.
     *
     */
    public function showAction(Realisation $realisation)
    {
        $deleteForm = $this->createDeleteForm($realisation);

        return $this->render('MultiBundle:realisation:show.html.twig', array(
            'realisation' => $realisation,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Realisation entity.
     *
     */
    public function editAction(Request $request, Realisation $realisation)
    {
        $deleteForm = $this->createDeleteForm($realisation);
        $editForm = $this->createForm('MultiBundle\Form\RealisationType', $realisation);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($realisation);
            $em->flush();

            return $this->redirectToRoute('realisation_edit', array('id' => $realisation->getId()));
        }

        return $this->render('MultiBundle:realisation:edit.html.twig', array(
            'realisation' => $realisation,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Realisation entity.
     *
     */
    public function deleteAction(Request $request, Realisation $realisation)
    {
        $form = $this->createDeleteForm($realisation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($realisation);
            $em->flush();
        }

        return $this->redirectToRoute('realisation_index');
    }

    /**
     * Creates a form to delete a Realisation entity.
     *
     * @param Realisation $realisation The Realisation entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Realisation $realisation)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('realisation_delete', array('id' => $realisation->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
