<?php
require_once("Game/Game.class.php");

$game = new Game();

switch ($argv[1]) {
	case 'show':
		switch ($argv[2]) {
			default:
				var_dump($game);
				break;
		}
		break;
	default:
		echo "Everything seems OK";
		break;
}