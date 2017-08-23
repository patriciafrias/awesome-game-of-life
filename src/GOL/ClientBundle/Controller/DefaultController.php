<?php

namespace GOL\ClientBundle\Controller;

use GuzzleHttp\Client;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;

class DefaultController extends Controller
{
    /** @const int */
    const BOARD_ROWS = 40;
    /** @const int */
    const BOARD_COLUMNS = 40;

    /** @var string */
    private $baseUrl = 'http://apache/app_dev.php';

    /**
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction(Request $request)
    {
        $client = new Client();

        $response = $client->request(
            'GET',
            $this->baseUrl . '/api/v1/initial-game',
            [
                'json' => [
                    'rows' => $this::BOARD_ROWS,
                    'columns' => $this::BOARD_COLUMNS,
                ]
            ]);

        $initialBoard = json_decode($response->getBody(), true);

        $response = $this->forward(
            'GOLClientBundle:Default:populate', ['status' => $initialBoard['status']]
        );

        return $response;
    }

    /**
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function populateAction(Request $request)
    {
        $boardStatus = $request->get('status');


        $client = new Client();

        $response = $client->request(
            'GET',
            $this->baseUrl . '/api/v1/populated-game',
            [
                'json' => [
                    'status'  => $boardStatus,
                    'rows'    => $this::BOARD_ROWS,
                    'columns' => $this::BOARD_COLUMNS,
                ]
            ]
        );

        $populatedBoard = json_decode($response->getBody(), true);

        $session = $request->getSession();
        $session->set('status', $populatedBoard['status']);

        return $this->render('GOLClientBundle:Default:index.html.twig', ['content' => $populatedBoard]);
    }

    /**
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \Exception
     */
    public function calculateNextCycleAction(Request $request)
    {
        $session = $request->getSession();

        if ($session->has('status')) {
            $boardStatus = $session->get('status');
            $session->invalidate();
        }
        else {
            throw new \Exception('Error. Game is not started.');
        }

        $client = new Client();

        $response = $client->request(
            'GET',
            $this->baseUrl . '/api/v1/next-cycle-game',
            [
                'json' => [
                    'status' => $boardStatus,
                    'rows' => $this::BOARD_ROWS,
                    'columns' => $this::BOARD_COLUMNS,
                ]
            ]
        );

        $nextCycleBoard = json_decode($response->getBody(), true);

        // Set status on session for next request.
        $session = $request->getSession();
        $session->set('status', $nextCycleBoard['status']);

        return $this->render('GOLClientBundle:Default:index.html.twig', ['content' => $nextCycleBoard]);
    }
}
