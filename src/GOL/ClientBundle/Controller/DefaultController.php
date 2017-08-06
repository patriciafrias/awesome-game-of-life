<?php

namespace GOL\ClientBundle\Controller;

use GuzzleHttp\Client;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /** @var string */
    private $baseUrl = 'http://apache/app_dev.php/';

    /**
     * Start game by default
     *
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction(Request $request)
    {

        $client = new Client([
            'base_uri' => $this->baseUrl,
            'timeout'  => 2.0,
        ]);

        $response = $client->request('GET', 'api/v1/start-game');

        return $this->render('GOLClientBundle:Default:index.html.twig', ['content' => $response->getBody()]);
    }
}
