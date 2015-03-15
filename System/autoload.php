<?php

function autoload($name)
{
	if (strpos($name, '../') !== false) {
		throw new \MazeGenerator\Exception\ApplicationException("Wrong class name");
	}

	$name = __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . substr($name, strlen('MazeGenerator/')) . '.php';

	if (file_exists($name)) {
		include_once($name);
	}
}

spl_autoload_register("autoload");