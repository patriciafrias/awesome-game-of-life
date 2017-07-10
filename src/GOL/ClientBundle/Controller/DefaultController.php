<?php

namespace GOL\ClientBundle\Controller;

use Guzzle\Http\Client;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /** @var string */
    private $baseUrl= 'http://gol.local.com/app_dev.php';

    /**
     * Start game by default
     *
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction(Request $request)
    {

        $client = new Client($this->baseUrl);

        $content = $client->get('/api/v1/start-game')
            ->send()
            ->getBody();

        return $this->render('GOLClientBundle:Default:index.html.twig', ['content' => $content]);
    }
}
