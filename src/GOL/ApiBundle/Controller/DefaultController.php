<?php

namespace GOL\ApiBundle\Controller;

use GOL\GameBundle\Domain\Board;
use GOL\GameBundle\Domain\Game;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends FOSRestController
{
    /**
     * Start game with an empty board.
     *
     * @Rest\Get("/start-game")
     */
    public function startGameAction(Request $request)
    {
        $board = new Board(40, 60);

        $game = new Game($board);

        $data = [
            'status' => 'OK',
            'data' => $game->getBoard()->getStatus(),
        ];

        return $this->view($data, Response::HTTP_OK);
    }

    /**
     * Populate game with random value in each position of the board.
     *
     * @Rest\Get("/populate-game")
     */
    public function populateGameAction(Request $request)
    {
        $board = new Board(40, 60);

        $game = new Game($board);

        $session = $request->getSession();

        $game->populateBoard();

        $newStatus = $game->getBoard();

        $session->set('board', $newStatus);

        $data = [
            'status' => 'OK',
            'data' => $newStatus->getStatus(),
        ];

        return $this->view($data, Response::HTTP_OK);
    }

    /**
     * Calculate next Life cycle
     *
     * @Rest\Get("/calculate-next-cycle")
     */
    public function calculateNextCycleAction(Request $request)
    {
        $session = $request->getSession();
        $board = $session->get('board');

        $game = new Game($board);

        $game->calculateNextLifeCycle();

        $newBoard = $game->getBoard()->getStatus();

        $data = [
            'status' => 'OK',
            'data' => $newBoard,
        ];

        return $this->view($data, Response::HTTP_OK);
    }
}
