<?php

function renderAvatar($avatar){
	$out =  "{".$avatar->currentHP."/".$avatar->maxHP."}";
	$out .= "(".$avatar->class.")";
	$out .= "{".$avatar->currentMP."/".$avatar->maxMP."}";
	return $out;
}

function renderDeck($deck){
	$out = "[".$deck->size()."]";
	if($deck->size() > 30){
		$out .= "]";
	}
	if($deck->size() > 20){
		$out .= "]";
	}
	if($deck->size() > 10){
		$out .= "]";
	}
	return $out;
}

function renderHand($hand){
	$out = "";
	foreach ($hand->getAll() as $card) {
		$out .= "[".$card->id."]";
	}
	return $out;
}

function renderDiscard($discard){
	$out = "|".$discard->size()."|";
	return $out;
}

function renderArena($arena){
	$out = "> ";
	$out .= renderHand($arena);
	$out .= " <";
	return $out;
}