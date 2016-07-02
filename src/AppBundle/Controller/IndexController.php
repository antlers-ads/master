<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Default application's controller.
 */
class IndexController extends Controller
{
    /**
     * Handles homepage page.
     */
    public function indexAction()
    {
        return $this->render('AppBundle:index:homepage.html.twig');
    }

    /**
     * Handles info page.
     */
    public function infoAction()
    {
        return $this->render('AppBundle:index:info.html.twig');
    }
}
