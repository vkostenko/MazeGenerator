<?php
namespace MazeGenerator\Test;

use \MazeGenerator\System\Factory;

class FactoryTest extends \PHPUnit_Framework_Testcase
{
	public function testGetSquareField()
	{
		$field = Factory::getInstance()->getSquareField(10, 10);
		$this->assertTrue($field instanceof \MazeGenerator\Field\ISquareField);
	}

	public function testGetSquareCell()
	{
		$class  = new \ReflectionClass('\MazeGenerator\System\Factory');
		$method = $class->getMethod('getSquareCell');
		$method->setAccessible(true);
		$factory = Factory::getInstance();

		$cell = $method->invoke($factory);

		$this->assertTrue($cell instanceof \MazeGenerator\Field\Cell\ISquareCell);
	}

	public function testGetEllerMazeGenerator()
	{
		$field = Factory::getInstance()->getSquareField(100, 100);
		$this->assertTrue($field instanceof \MazeGenerator\Field\ISquareField);

		$generator = Factory::getInstance()->getEllerMazeGenerator($field);
		$this->assertTrue($generator instanceof \MazeGenerator\Generator\AbstractGenerator);
		$this->assertTrue($generator instanceof \MazeGenerator\Generator\Eller\Generator);
	}

	public function testGetLineSet()
	{
		$class  = new \ReflectionClass('\MazeGenerator\System\Factory');
		$method = $class->getMethod('getLineSet');
		$method->setAccessible(true);
		$factory = \MazeGenerator\System\Factory::getInstance();

		$line = $method->invoke($factory);
		$this->assertTrue($line instanceof \MazeGenerator\Generator\Eller\ILineSet);
	}

	public function testGetSquareFieldHtmlOutput()
	{
		$factory = \MazeGenerator\System\Factory::getInstance();
		$field = $factory->getSquareField(100, 100);
		$output = $factory->getSquareFieldHtmlOutput($field);
		$this->assertTrue($output instanceof \MazeGenerator\Output\SquareField\Html);
	}

	public function testGetSquareFieldHtmlDecorator()
	{
		$class  = new \ReflectionClass('\MazeGenerator\System\Factory');
		$method = $class->getMethod('getSquareFieldHtmlDecorator');
		$method->setAccessible(true);
		$factory = \MazeGenerator\System\Factory::getInstance();

		$field = $factory->getSquareField(100, 100);
		$fieldHtml = $method->invoke($factory, $field);
		$this->assertTrue($fieldHtml instanceof \MazeGenerator\Output\SquareField\Decorator\Html);
	}

}

?>