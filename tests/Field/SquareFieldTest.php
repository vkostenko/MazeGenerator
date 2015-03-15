<?php

namespace MazeGenerator\Test;

use MazeGenerator\Field\Cell\ISquareCell;
use \MazeGenerator\System\Factory;

class SquareFieldTest extends \PHPUnit_Framework_Testcase
{
	/**
	 * @covers MazeGenerator\Field\SquareField::getWidth
	 * @covers MazeGenerator\Field\SquareField::getHeight
	 * @dataProvider fieldSizeProvider
	 */
	public function testGetSize($width, $height, $expectedWidth, $expectedHeight)
	{
		$squareField = Factory::getInstance()->getSquareField($width, $height);
		$this->assertEquals($expectedWidth, $squareField->getWidth());
		$this->assertEquals($expectedHeight, $squareField->getHeight());
	}

	public function fieldSizeProvider()
	{
		return [
			[2, 2, 2, 2],
			[1000, 1000, 1000, 1000],
			[10, 20, 10, 20],
			[0, 0, 2, 2],
			[1200, 1200, 1000, 1000]
		];
	}

	/**
	 * @depends testGetSize
	 */
	public function testHasBorder()
	{
		$squareField = Factory::getInstance()->getSquareField(30, 30);
		$this->assertTrue($squareField->hasBorder(0, 5, ISquareCell::BORDER_LEFT));
		$this->assertTrue($squareField->hasBorder(5, 0, ISquareCell::BORDER_TOP));
		$this->assertTrue($squareField->hasBorder($squareField->getWidth() - 1, 5, ISquareCell::BORDER_RIGHT));
		$this->assertTrue($squareField->hasBorder(5, $squareField->getHeight() - 1, ISquareCell::BORDER_BOTTOM));

		$this->assertFalse($squareField->hasBorder(5, 5, ISquareCell::BORDER_BOTTOM));
		$this->assertFalse($squareField->hasBorder(7, 12, ISquareCell::BORDER_RIGHT));
		$this->assertFalse($squareField->hasBorder(3, 15, ISquareCell::BORDER_LEFT));
		$this->assertFalse($squareField->hasBorder(11, 13, ISquareCell::BORDER_TOP));
	}

	/**
	 * @depends testGetSize
	 * @depends testHasBorder
	 */
	public function testAddRoundBorder()
	{
		$borders = 0;
		$squareField = Factory::getInstance()->getSquareField(20, 20);
		for ($y = 0; $y < $squareField->getHeight(); $y++) {
			$borders += $squareField->hasBorder(0, $y, ISquareCell::BORDER_LEFT);
			$borders += $squareField->hasBorder($squareField->getWidth() - 1, $y, ISquareCell::BORDER_RIGHT);
		}
		for ($x = 0; $x < $squareField->getWidth(); $x++) {
			$borders += $squareField->hasBorder($x, 0, ISquareCell::BORDER_TOP);
			$borders += $squareField->hasBorder($x, $squareField->getHeight() - 1, ISquareCell::BORDER_BOTTOM);
		}

		$this->assertEquals($borders, 2*$x + 2*$y - 2);
	}

	/**
	 * @depends testGetSize
	 * @covers \MazeGenerator\Field\SquareField::addBorder
	 * @covers \MazeGenerator\Field\SquareField::removeBorder
	 * @covers \MazeGenerator\Field\SquareField::hasBorder
	 * @dataProvider borderProvider
	 */
	public function testCellOperations($x, $y, $border1, $border2)
	{
		$field = Factory::getInstance()->getSquareField(100, 100);
		$this->assertFalse($field->hasBorder($x, $y, $border1));
		$this->assertFalse($field->hasBorder($x, $y, $border2));
		$field->addBorder($x, $y, $border1);
		$this->assertTrue($field->hasBorder($x, $y, $border1));
		$this->assertFalse($field->hasBorder($x, $y, $border2));
		$field->addBorder($x, $y, $border2);
		$this->assertTrue($field->hasBorder($x, $y, $border1));
		$this->assertTrue($field->hasBorder($x, $y, $border2));
		$field->removeBorder($x, $y, $border1);
		$this->assertFalse($field->hasBorder($x, $y, $border1));
		$this->assertTrue($field->hasBorder($x, $y, $border2));
	}

	public function borderProvider()
	{
		return [
			[3,  5, ISquareCell::BORDER_RIGHT, ISquareCell::BORDER_BOTTOM],
			[12, 5, ISquareCell::BORDER_LEFT, ISquareCell::BORDER_RIGHT],
			[19, 2, ISquareCell::BORDER_TOP, ISquareCell::BORDER_LEFT],
			[6,  3, ISquareCell::BORDER_BOTTOM, ISquareCell::BORDER_TOP]
		];
	}
}




