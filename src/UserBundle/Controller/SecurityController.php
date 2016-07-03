<?php

namespace UserBundle\Controller;

use FOS\UserBundle\Controller\SecurityController as BaseSecurityController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;

/**
 * Overrides FOSUserBundle in order to provide custom logic.
 */
class SecurityController extends BaseSecurityController
{
    /**
     * Prevents logged users to view login page.
     *
     * @return RedirectResponse|Response
     */
    public function loginAction()
    {
        $securityContext = $this->container->get('security.authorization_checker');
        if ($securityContext->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            return new RedirectResponse($this->container->get('router')->generate('homepage'));
        }

        return parent::loginAction();
    }
}
