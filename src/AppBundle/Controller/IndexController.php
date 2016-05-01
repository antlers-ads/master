<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Default application's controller.
 */
class IndexController extends Controller
{
    /**
     * Handles main page.
     */
    public function indexAction()
    {
        return $this->render('AppBundle:index:index.html.twig');
    }
}
