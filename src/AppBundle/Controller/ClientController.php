<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Client;
use AppBundle\Form\Type\ClientType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;

/**
 * Default controller for actions related to clients.
 */
class ClientController extends Controller
{
    /**
     * Handles list page.
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function listAction(Request $request)
    {
        $paginator = $this->get('knp_paginator');
        $repository = $this->getDoctrine()->getRepository('AppBundle:Client');
        $pagination = $paginator->paginate($repository->getAllQuery(), $request->get('page', 1));

        return $this->render('AppBundle:client:list.html.twig', ['pagination' => $pagination]);
    }

    /**
     * Creates a new entity.
     *
     * @param Request $request
     * @return RedirectResponse|Response
     */
    public function addAction(Request $request)
    {
        $entity = new Client();

        $form = $this->createForm(new ClientType(), $entity, [
            'action' => $this->generateUrl('client_add'),
            'method' => 'PUT'
        ])->add('submit', 'submit', [
            'attr' => ['class' => 'btn btn-default pull-left btn-add']
        ]);

        if ($request->isMethod('PUT')) {
            $form->handleRequest($request);

            if ($form->isValid()) {
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($entity);
                $entityManager->flush();
                $this->addFlash('success', 'Successfully added new client.');

                return $this->redirect($this->generateUrl('client_list'));
            }
        }

        return $this->render('AppBundle:Client:add.html.twig', [
            'entity' => $entity,
            'form' => $form->createView()
        ]);
    }

    /**
     * Edits an existing client entity.
     *
     * @param Request $request
     * @param integer $id
     * @return RedirectResponse|Response
     */
    public function editAction(Request $request, $id)
    {
        $repository = $this->getDoctrine()->getRepository('AppBundle:Client');
        $entity = $repository->getById($id);

        if (!$entity) {
            throw $this->createNotFoundException();
        }

        $form = $this->createForm(new ClientType(), $entity, [
            'action' => $this->generateUrl('client_edit', ['id' => $entity->getId()]),
            'method' => 'POST',
        ])->add('submit', 'submit', [
            'attr' => ['class' => 'btn btn-default pull-left']
        ]);

        if ($request->isMethod('POST')) {
            $form->handleRequest($request);

            if ($form->isValid()) {
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->flush();
                $this->addFlash('success', 'Successfully changed the client.');
                return $this->redirect($this->generateUrl('client_list'));
            }
        }

        return $this->render('AppBundle:Client:edit.html.twig', [
            'entity' => $entity,
            'form' => $form->createView()
        ]);
    }

    /**
     * Deletes a client entity.
     *
     * @param Request $request
     * @param integer $id
     * @return RedirectResponse
     */
    public function deleteAction(Request $request, $id)
    {
        $repository = $this->getDoctrine()->getRepository('AppBundle:Client');
        $entity = $repository->getById($id);

        if (!$entity) {
            throw $this->createNotFoundException();
        }

        $form = $this->createFormBuilder()
            ->setAction($this->generateUrl('client_delete', ['id' => $id]))
            ->setMethod('DELETE')
            ->add('submit', 'submit', [
                'label' => 'Delete',
                'attr' => ['class' => 'btn btn-danger pull-right']
            ])->getForm();

        if ($request->isMethod('DELETE')) {
            $form->handleRequest($request);

            if ($form->isValid()) {
                if (!$entity->getAdvertisements()->isEmpty()) {
                    $this->addFlash('error', 'There are advertisements associated with this client.');
                } else {
                    $entityManager = $this->getDoctrine()->getManager();
                    $entityManager->remove($entity);
                    $entityManager->flush();
                    $this->addFlash('success', 'Successfully deleted the client.');
                }

                return $this->redirect($this->generateUrl('client_list'));
            }
        }

        return $this->render('AppBundle:Client:delete.html.twig', [
            'entity' => $entity,
            'form' => $form->createView()
        ]);
    }
}
