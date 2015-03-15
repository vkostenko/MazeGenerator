<?php
namespace MazeGenerator\System;

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

}

?>