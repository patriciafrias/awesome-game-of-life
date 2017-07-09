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
     * Start game
     * @Rest\Get("/start-game")
     */
    public function startGameAction(Request $request)
    {
        $board = new Board(3, 3);

        $game = new Game($board);

        $data = [
            'status' => 'OK',
            'data' => $game->getBoard()->getStatus(),
        ];

        return $this->view($data, Response::HTTP_OK);
    }

//    /**
//     * Populate game
//     * @Rest\Get("/populate-game")
//     */
//    public function populateGameAction(Request $request)
//    {
//
//    }
}
