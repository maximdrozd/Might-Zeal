<?php
require_once("Game/Card.class.php");

$card = new Card(array());

switch ($argv[1]) {
	case 'show':
		# code...
		break;
	default:
		var_dump($card);
		break;
}
