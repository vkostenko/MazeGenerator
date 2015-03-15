<?php

namespace MazeGenerator\Test;

use MazeGenerator\Field\Cell\ISquareCell;
use MazeGenerator\Field\ISquareField;
use \MazeGenerator\System\Factory;

class HtmlDecoratorTest extends \PHPUnit_Framework_Testcase
{
	/**
	 * @covers \MazeGenerator\Output\SquareField\Decorator\Html::getWidth
	 * @covers \MazeGenerator\Output\SquareField\Decorator\Html::getHeight
	 * @dataProvider sizeProvider
	 */
	public function testGetSize($width, $height)
	{
		$field = Factory::getInstance()->getSquareField($width, $height);
		$decorator = $this->getDecorator($field);

		$this->assertEquals($decorator->getWidth(), $width);
		$this->assertEquals($decorator->getHeight(), $height);
	}

	/**
	 * @param ISquareField $field
	 *
	 * @return \MazeGenerator\Output\SquareField\Decorator\Html
	 */
	private function getDecorator(ISquareField $field)
	{
		$class  = new \ReflectionClass('\MazeGenerator\System\Factory');
		$method = $class->getMethod('getSquareFieldHtmlDecorator');
		$method->setAccessible(true);

		return $method->invoke(Factory::getInstance(), $field);
	}

	public function sizeProvider()
	{
		return [
			[100, 150],
			[10, 10],
			[2, 2],
			[1000, 999]
		];
	}

	/**
	 * @covers \MazeGenerator\Output\SquareField\Decorator\Html::getClasses
	 */
	public function testGetClasses()
	{
		$field = Factory::getInstance()->getSquareField(20, 30);
		$field->addBorder(5, 10, ISquareCell::BORDER_BOTTOM);
		$field->addBorder(5, 10, ISquareCell::BORDER_RIGHT);
		$field->addBorder(3, 15, ISquareCell::BORDER_BOTTOM);
		$field->addBorder(4, 20, ISquareCell::BORDER_RIGHT);

		$decorator = $this->getDecorator($field);

		$data = [
			[ 0,  5, ['left'],            ['top']  ],
			[ 19, 0, ['top', 'right'],    ['left'] ],
			[ 7, 29, ['bottom'],          ['left'] ],
			[ 0, 29, ['bottom', 'left'],  ['top']  ],
			[ 5, 10, ['bottom', 'right'], ['left', 'top'] ],
			[ 3, 15, ['bottom'],          ['left', 'right', 'top'] ],
			[ 4, 20, ['right'],           ['left', 'bottom', 'top'] ],
		];

		foreach ($data as $cell) {
			list ($x, $y, $expected, $unexpected) = $cell;
			$classes = explode(' ', $decorator->getClasses($x, $y));
			$this->assertEquals(count(array_intersect($classes, $expected)), count($expected));
			$this->assertEquals(array_intersect($classes, $unexpected), []);
		}
	}
}