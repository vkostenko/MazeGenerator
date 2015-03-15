<?php

namespace MazeGenerator\Output\SquareField\Decorator;

use MazeGenerator\Field\ISquareField;

interface IHtml
{
	public function __construct(ISquareField $field);

	public function getWidth();

	public function getHeight();

	public function getClasses( $x, $y );
}
