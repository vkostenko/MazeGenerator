<?php

namespace MazeGenerator\Output\SquareField\Decorator;

use MazeGenerator\Field\ISquareField;

class Html implements IHtml
{
	/**
	 * @var ISquareField
	 */
	private $field;

	public function __construct(ISquareField $field)
	{
		$this->field = $field;
	}

	public function getWidth() {
		return $this->field->getWidth();
	}

	public function getHeight() {
		return $this->field->getHeight();
	}

	public function getClasses( $x, $y ) {
		$classes  = $this->field->hasBorder($x, $y, \MazeGenerator\Field\Cell\ISquareCell::BORDER_RIGHT) ? 'right ' : '';
		$classes .= $this->field->hasBorder($x, $y, \MazeGenerator\Field\Cell\ISquareCell::BORDER_BOTTOM) ? 'bottom ' : '';
		if ($x === 0 & $y !== 0) {
			$classes .= 'left ';
		}
		if ($y === 0) {
			$classes .= 'top ';
		}

		return $classes;
	}
}
