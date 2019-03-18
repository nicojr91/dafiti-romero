<?php

main();

function main() {
	echo "Ingrese las cartas separados por comas.\n";
	echo "Ingresando 0 se cierra el programa.\n\n";

	$input = getInput();
	while ($input != 0) {
		$errors = validateInput($input);
		if(count($errors) > 0) {
			foreach ($errors as $error) {
				echo $error."\n";
			}
			die;
		}
		$values = explode(",", $input);
		$values = array_map('trim', $values);
		if(isStraight($values)) {
			echo "escalera\n";
		} else {
			echo "no es escalera\n";
		}

		$input = getInput();
	}
}

function getInput() {
	echo "Ingrese las cartas: ";
	return readline();
}

function validateInput(string $input) {
	$errors = [];

	if(strpos($input, ',') === -1) {
		$errors[] = "El texto no esta separado por comas.\n";
		return $errors;
	} 
	
	$values = explode(",", $input);
	$values = array_map('trim', $values);
	foreach ($values as $key => $value) {
		if(!is_numeric($value)) {
			$errors[] = "La carta nº".($key+1)." no es un numero.\n";
			continue;
		}
		if($value < 2 && $value > 14) {
			$errors[] = "La carta nº".($key+1)." no puede ser menor que 2 y mayor que 14.\n";
			continue;
		}
	}

	return $errors;
}

function isStraight(array $values) {
	$values = bubbleSort($values);
	$lastValue = -1;
	$score = 0;

	foreach ($values as $value) {
		if($lastValue != -1) {
			if(($lastValue + 1) == (int)$value) {
				$score++;
			}
		}
		$lastValue = (int)$value;
	}

	if($score >= 3) {
		return true;
	}

	return false;
}

function bubbleSort(array $values) {
	$isSorted = false;
	while(!$isSorted) {
		$isSorted = true;
		for($i = 0; $i < count($values); $i++) {
			$e = $i+1;
			if(isset($values[$e]) && $values[$i] > $values[$e]) {
				$buff = $values[$i];
				$values[$i] = $values[$e];
				$values[$e] = $buff;
				$isSorted = false;
			}
		}
	}

	if($values[0] == 2 && $values[count($values)-1] == 14) {
		$lastValue = null;
		$countPositions = count($values);
		for($i = ($countPositions-1); $i >= 0 ; $i--) {
			if(!isset($lastValue)) {
				$lastValue = $values[$i];
				continue;
			}
			$values[$i+1] = $values[$i];
		}
		$values[0] = "1";
	}


	return $values;
}

function dd($e) {
	var_dump($e);
	die();
}