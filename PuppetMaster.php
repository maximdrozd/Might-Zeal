<?php
ini_set('xdebug.var_display_max_depth', -1);
ini_set('xdebug.var_display_max_children', -1);
ini_set('xdebug.var_display_max_data', -1);

require_once("Game/Game.class.php");
require_once("Game/Card.class.php");

$com = (isset($argv[1])) ? $argv[1] : "CLI";
$com = (isset($_REQUEST["com"])) ? $_REQUEST["com"] : $com;

$game = new Game();

switch ($com) {
	case 'testCardMove':
		$game->players[0]->deck->push(new Card(array("id" => 1)));
		$game->players[0]->deck->push(new Card(array("id" => 2)));
		$game->players[0]->deck->push(new Card(array("id" => 3)));
		$game->players[0]->deck->push(new Card(array("id" => 4)));
		$game->players[0]->drawCard();
		$game->players[0]->playCard(1);
		$game->players[0]->returnCardToHand(1);
		var_dump($game);
		break;
	default:
		echo "Everything seems OK";
		break;
}