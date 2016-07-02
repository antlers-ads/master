<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Advertisement;
use AppBundle\Form\Type\AdvertisementType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Default controller for actions related to advertisements.
 */
class AdvertisementController extends Controller
{
    /**
     * Handles list page.
     *
     * @param Request $request
     * @return Response
     */
    public function listAction(Request $request)
    {
        $paginator = $this->get('knp_paginator');
        $repository = $this->getDoctrine()->getRepository('AppBundle:Advertisement');
        $pagination = $paginator->paginate($repository->getAllQuery(), $request->get('page', 1));

        return $this->render('AppBundle:advertisement:list.html.twig', ['pagination' => $pagination]);
    }

    /**
     * Creates a new entity.
     *
     * @param Request $request
     * @return RedirectResponse|Response
     */
    public function addAction(Request $request)
    {
        $entity = new Advertisement();

        $form = $this->createForm(new AdvertisementType(), $entity, [
            'action' => $this->generateUrl('advertisement_add'),
            'method' => 'PUT'
        ])->add('submit', 'submit', [
            'attr' => ['class' => 'btn btn-default pull-left btn-add']
        ]);

        if ($request->isMethod('PUT')) {
            $form->handleRequest($request);

            if ($form->isValid()) {
                /** @var \Symfony\Component\HttpFoundation\File\UploadedFile $file */
                $file = $entity->getImage();

                $fileName = md5(uniqid()) . '.' . $file->guessExtension();
                $file->move($this->getParameter('images_directory'), $fileName);
                list($width, $height) = getimagesize($this->getParameter('images_directory') . '/' . $fileName);

                $entity->setWidth($width);
                $entity->setHeight($height);
                $entity->setImage($fileName);

                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($entity);
                $entityManager->flush();
                $this->addFlash('success', 'Successfully added new advertisement.');

                return $this->redirect($this->generateUrl('advertisement_list'));
            }
        }

        return $this->render('AppBundle:advertisement:add.html.twig', [
            'entity' => $entity,
            'form' => $form->createView()
        ]);
    }

    /**
     * Edits an existing advertisement entity.
     *
     * @param Request $request
     * @param integer $id
     * @return RedirectResponse|Response
     */
    public function editAction(Request $request, $id)
    {
        $repository = $this->getDoctrine()->getRepository('AppBundle:Advertisement');
        $entity = $repository->getById($id);

        if (!$entity) {
            throw $this->createNotFoundException();
        }

        $form = $this->createForm(new AdvertisementType(), $entity, [
            'action' => $this->generateUrl('advertisement_edit', ['id' => $entity->getId()]),
            'method' => 'POST',
        ])->add('submit', 'submit', [
            'attr' => ['class' => 'btn btn-default pull-left']
        ]);

        if ($request->isMethod('POST')) {
            $form->handleRequest($request);

            if ($form->isValid()) {
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->flush();
                $this->addFlash('success', 'Successfully changed the advertisement.');
                return $this->redirect($this->generateUrl('advertisement_list'));
            }
        }

        return $this->render('AppBundle:advertisement:edit.html.twig', [
            'entity' => $entity,
            'form' => $form->createView()
        ]);
    }

    /**
     * Deletes a advertisement entity.
     *
     * @param Request $request
     * @param integer $id
     * @return RedirectResponse
     */
    public function deleteAction(Request $request, $id)
    {
        $repository = $this->getDoctrine()->getRepository('AppBundle:Advertisement');
        $entity = $repository->getById($id);

        if (!$entity) {
            throw $this->createNotFoundException();
        }

        $form = $this->createFormBuilder()
            ->setAction($this->generateUrl('advertisement_delete', ['id' => $id]))
            ->setMethod('DELETE')
            ->add('submit', 'submit', [
                'label' => 'Delete',
                'attr' => ['class' => 'btn btn-danger pull-right']
            ])->getForm();

        if ($request->isMethod('DELETE')) {
            $form->handleRequest($request);

            if ($form->isValid()) {
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->remove($entity);
                $entityManager->flush();
                $this->addFlash('success', 'Successfully deleted the advertisement.');
                return $this->redirect($this->generateUrl('advertisement_list'));
            }
        }

        return $this->render('AppBundle:advertisement:delete.html.twig', [
            'entity' => $entity,
            'form' => $form->createView()
        ]);
    }
}
