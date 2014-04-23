<?php
namespace Game\Models;

use Game\Enum\EnvironmentType;

class PlayingField {
	protected $environment;

	public function __construct($parameterMap){
		$this->environment = initWithVar("environment", $parameterMap, EnvironmentType::UNKNOWN);
	}
}
