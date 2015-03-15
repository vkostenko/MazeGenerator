<?php

$width  = isset($_GET['width']) ? intval($_GET['width']) : 30;
$height = isset($_GET['height']) ? intval($_GET['height']) : 30;


include_once('System' . DIRECTORY_SEPARATOR . 'autoload.php');


$factory = \MazeGenerator\System\Factory::getInstance();

$field = $factory->getSquareField($width, $height);
$field = $factory->getEllerMazeGenerator($field)->generateMaze()->getField();

$fieldHtml = new MazeGenerator\Output\SquareField\Decorator\Html($field);

$output = new MazeGenerator\Output\SquareField\Html($fieldHtml);
$output->out();


?>