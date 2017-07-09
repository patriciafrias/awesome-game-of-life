<?php

namespace GOL\ClientBundle\Controller;

use Guzzle\Http\Client;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /** @var string */
    private $baseUrl = 'http://gol.local.com/app_dev.php';

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction(Request $request)
    {
        $client = new Client();

        //$content = $client->get('GET', $this->baseUrl . '/api/v1/start-game');

        return $this->render('GOLClientBundle:Default:index.html.twig', ['content' => 'aaaa']); //$content]);
    }
}
