<?php
namespace MazeGenerator\Test;

use \MazeGenerator\System\Factory;

class GeneratorTest extends \PHPUnit_Framework_Testcase
{
	/**
	 * @var array
	 */
	private $generators;

	/**
	 * @param $width
	 * @param $height
	 *
	 * @return \MazeGenerator\Generator\Eller\Generator
	 */
	private function getGenerator($width, $height)
	{
		if (!isset($this->generators[$width][$height])) {
			$field = Factory::getInstance()->getSquareField($width, $height);
			$this->generators[$width][$height] = Factory::getInstance()->getEllerMazeGenerator($field);
		}
		return $this->generators[$width][$height];
	}

	public function testGetField()
	{
		$generator = $this->getGenerator(100, 150);
		$field = $generator->getField();
		$this->assertTrue($field instanceof \MazeGenerator\Field\IField);
		$this->assertTrue($field instanceof \MazeGenerator\Field\ISquareField);
		$this->assertEquals($field->getWidth(), 100);
		$this->assertEquals($field->getHeight(), 150);
	}

	public function testGenerateMaze() {}

	public function testGetRandomVerticalBorders()
	{
		$class = new \ReflectionClass('\MazeGenerator\Generator\Eller\Generator');
		$method = $class->getMethod('getRandomVerticalBorders');
		$method->setAccessible(true);

		$data = $method->invoke($this->getGenerator(100, 150));
		$this->assertTrue(count($data) > 0 && count($data) < 100);

		$data = $method->invoke($this->getGenerator(2, 5));
		$this->assertTrue(count($data) === 0);

		$data = $method->invoke($this->getGenerator(4, 5));
		$this->assertTrue(count($data) > 0 && count($data) < 4);
	}

	/**
	 * @dataProvider positionsForHorizontalBorders
	 */
	public function testGetRandomHorizontalBorders($positions) {
		$class = new \ReflectionClass('\MazeGenerator\Generator\Eller\Generator');
		$method = $class->getMethod('getRandomHorizontalBorders');
		$method->setAccessible(true);

		$data = $method->invoke($this->getGenerator(100, 150), $positions);
		if (count($positions) < 2) {
			$this->assertEmpty($data);
		} else {
			$this->assertTrue(count($data) > 0 && count($data) < count($positions));
		}
	}

	public function positionsForHorizontalBorders()
	{
		return [
			[[1, 2, 3]],
			[[1, 2, 4, 5, 6]],
			[[0]],
			[[0, 5, 7, 19, 23, 5]]
		];
	}

	public function testSetBorderBottoms() {}

	public function testFillTopLine() {}

	public function testFillLine() {}

	public function testFillBottomLine() {}
}


?>