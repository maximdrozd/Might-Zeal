<?php

function initWithVar($parameterName, $assignmentMap, $assignmentDefault = null){
	if(isset($assignmentMap) && isset($assignmentMap[$parameterName])){
		return $assignmentMap[$parameterName];
	} else {
		return $assignmentDefault;
	}
}
