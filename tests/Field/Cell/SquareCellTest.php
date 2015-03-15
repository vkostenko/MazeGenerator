<?php

namespace MazeGenerator\Test;

use MazeGenerator\Field\Cell\ISquareCell;

class SquareCellTest extends \PHPUnit_Framework_Testcase
{
	/**
	 * @return \MazeGenerator\Field\Cell\ISquareCell
	 */
	private function getSquareCellObject()
	{
		$class  = new \ReflectionClass('\MazeGenerator\System\Factory');
		$method = $class->getMethod('getSquareCell');
		$method->setAccessible(true);
		$factory = \MazeGenerator\System\Factory::getInstance();

		return $method->invoke($factory);
	}

	/**
	 * @covers \MazeGenerator\Field\Cell\SquareCell::get
	 * @covers \MazeGenerator\Field\Cell\SquareCell::set
	 * @dataProvider cellValueProvider
	 */
	public function testSetGet($borders, $expected)
	{
		$cell = $this->getSquareCellObject();
		$cell->set($borders);
		$this->assertEquals($expected, $cell->get());
	}

	/**
	 * @depends testSetGet
	 * @covers \MazeGenerator\Field\Cell\SquareCell::addBorder
	 * @covers \MazeGenerator\Field\Cell\SquareCell::removeBorder
	 * @covers \MazeGenerator\Field\Cell\SquareCell::hasBorder
	 * @dataProvider borderProvider
	 */
	public function testBorderOperations($border1, $border2)
	{
		$cell = $this->getSquareCellObject();
		$cell->set(0);
		$this->assertFalse($cell->hasBorder($border1));
		$this->assertFalse($cell->hasBorder($border2));
		$cell->addBorder($border1);
		$this->assertTrue($cell->hasBorder($border1));
		$this->assertFalse($cell->hasBorder($border2));
		$cell->addBorder($border2);
		$this->assertTrue($cell->hasBorder($border1));
		$this->assertTrue($cell->hasBorder($border2));
		$cell->removeBorder($border1);
		$this->assertFalse($cell->hasBorder($border1));
		$this->assertTrue($cell->hasBorder($border2));
	}

	public function cellValueProvider()
	{
		return [
			[0, 0],
			[3, 3],
			[15, 15]
		];
	}

	public function borderProvider()
	{
		return [
			[ISquareCell::BORDER_RIGHT, ISquareCell::BORDER_LEFT],
			[ISquareCell::BORDER_LEFT, ISquareCell::BORDER_BOTTOM],
			[ISquareCell::BORDER_TOP, ISquareCell::BORDER_RIGHT],
			[ISquareCell::BORDER_BOTTOM, ISquareCell::BORDER_TOP]
		];
	}
}




