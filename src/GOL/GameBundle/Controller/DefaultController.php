<?php

namespace GOL\GameBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('GOLGameBundle:Default:index.html.twig');
    }
}
