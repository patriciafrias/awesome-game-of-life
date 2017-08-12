<?php

namespace GOL\ClientBundle\Controller;

use GuzzleHttp\Client;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /** @var string */
    const COOKIE_FILE = '/tmp/cookie';

    /** @var string */
    private $baseUrl = 'http://apache/app_dev.php';

    /**
     * Start game by default
     *
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction(Request $request)
    {
        $content2 = $this->executeCurlRequest($this->baseUrl . '/api/v1/start-game');
        $content2 = $this->executeCurlRequest($this->baseUrl . '/api/v1/populate-game');

        return $this->render('GOLClientBundle:Default:index.html.twig', ['content' => $content2]);
    }

    /**
     * @param string $url
     * @return mixed
     */
    private function executeCurlRequest(string $url)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt ($ch, CURLOPT_COOKIEJAR, self::COOKIE_FILE);
        curl_setopt ($ch, CURLOPT_COOKIEFILE, self::COOKIE_FILE);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-type: application/json'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        $response = curl_exec($ch);

        $content = json_decode($response, true);

        return $content;
    }
}
