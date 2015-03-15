<?php
namespace MazeGenerator\System;

use MazeGenerator\Field\ISquareField;

class Factory
{
	use tSingleton;

	/**
	 * @param $width
	 * @param $height
	 *
	 * @return \MazeGenerator\Field\ISquareField
	 */
	public function getSquareField($width, $height)
	{
		$squareCell = $this->getSquareCell();

		return new \MazeGenerator\Field\SquareField($squareCell, intval($width), intval($height));
	}

	/**
	 * @return \MazeGenerator\Field\Cell\ISquareCell
	 */
	private function getSquareCell()
	{
		return new \MazeGenerator\Field\Cell\SquareCell();
	}

	/**
	 * @param \MazeGenerator\Field\ISquareField $field
	 *
	 * @return \MazeGenerator\Generator\AbstractGenerator
	 */
	public function getEllerMazeGenerator(\MazeGenerator\Field\ISquareField $field)
	{
		$lineSet = $this->getLineSet();

		return new \MazeGenerator\Generator\Eller\Generator($field, $lineSet);
	}

	/**
	 * @return \MazeGenerator\Generator\Eller\ILineSet
	 */
	private function getLineSet()
	{
		return \MazeGenerator\Generator\Eller\LineSet::getInstance();
	}

	/**
	 * @param ISquareField $field
	 *
	 * @return \MazeGenerator\Output\SquareField\Html
	 */
	public function getSquareFieldHtmlOutput(ISquareField $field)
	{
		$fieldHtml = $this->getSquareFieldHtmlDecorator($field);
		return new \MazeGenerator\Output\SquareField\Html($fieldHtml);
	}

	/**
	 * @param ISquareField $field
	 *
	 * @return \MazeGenerator\Output\SquareField\Decorator\Html
	 */
	private function getSquareFieldHtmlDecorator(ISquareField $field)
	{
		return new \MazeGenerator\Output\SquareField\Decorator\Html($field);
	}
}

?>