<?php
require_once("Game/Card.class.php");
require_once("Game/PlayingField.class.php");

$card = new Card(array());
$field = new PlayingField(array());

switch ($argv[1]) {
	case 'show':
		switch ($argv[2]) {
			case 'card':
				var_dump($card);
				break;
			case 'field':
				var_dump($field);
				break;
			default:
				var_dump($card);
				var_dump($field);
				break;
		}
		break;
	default:
		echo "Everything seems OK";
		break;
}