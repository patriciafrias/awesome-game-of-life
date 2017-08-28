<?php

namespace GOL\ApiBundle\Controller;

use GOL\GameBundle\Domain\Board;
use GOL\GameBundle\Domain\Game;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use GOL\GameBundle\Domain\MinorityPositivePopulateStrategy;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends FOSRestController
{
	/**
	 * Start game with an empty board.
	 *
	 * @Rest\Get("/initial-game")
	 *
	 * @param Request $request
	 *
	 * @return array
	 */
	public function startGameAction(Request $request)
	{
		$inputData = json_decode($request->getContent(), true);

		// TODO: may be better to add a function to get the data fields from the request.

		$boardRows = isset($inputData['rows']) ? $inputData['rows'] : null;
		$boardColumns = isset($inputData['columns']) ? $inputData['columns'] : null;

		$board = new Board($boardRows, $boardColumns);

		$populateStrategy = new MinorityPositivePopulateStrategy();

		$game = new Game($board, $populateStrategy);

		$initialBoard = $game->getBoard()->getStatus() ? $game->getBoard()->getStatus() : '';

		$data = ['status' => $initialBoard,];

		return $data;
	}

	/**
	 * Populate game with random value in each position of the board.
	 *
	 * @Rest\Get("/populated-game")
	 *
	 * @param Request $request
	 *
	 * @return array
	 */
	public function populateGameAction(Request $request)
	{
		$inputData = json_decode($request->getContent(), true);

		$boardStatus = isset($inputData['status']) ? $inputData['status'] : null;
		$boardRows = isset($inputData['rows']) ? $inputData['rows'] : null;
		$boardColumns = isset($inputData['columns']) ? $inputData['columns'] : null;

		$board = new Board($boardRows, $boardColumns);

		$board->setStatus($boardStatus);

		$populateStrategy = new MinorityPositivePopulateStrategy();

		$game = new Game($board, $populateStrategy);

		$game->populateBoard();

		$populatedBoard = $game->getBoard()->getStatus() ? $game->getBoard()->getStatus() : '';

		$data = ['status' => $populatedBoard,];

		return $data;
	}

	/**
	 * Get the next board status.
	 *
	 * @Rest\Get("/next-cycle-game")
	 *
	 * @param Request $request
	 *
	 * @return array
	 */
	public function calculateNextCycleAction(Request $request)
	{
		$inputData = json_decode($request->getContent(), true);

		$boardStatus = isset($inputData['status']) ? $inputData['status'] : null;
		$boardRows = isset($inputData['rows']) ? $inputData['rows'] : null;
		$boardColumns = isset($inputData['columns']) ? $inputData['columns'] : null;

		$board = new Board($boardRows, $boardColumns);

		$populateStrategy = new MinorityPositivePopulateStrategy();
		$game = new Game($board, $populateStrategy);

		$board->setStatus($boardStatus);

		$game->calculateNextLifeCycle();

		$nextLifeCycleData = $game->getBoard()->getStatus() ? $game->getBoard()->getStatus() : '';

		$data = ['status' => $nextLifeCycleData,];

		return $data;
	}
}
