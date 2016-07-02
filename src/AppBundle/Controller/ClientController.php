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
}
