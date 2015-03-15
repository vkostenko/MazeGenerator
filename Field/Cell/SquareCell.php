<?php
namespace MazeGenerator\Field\Cell;

class SquareCell implements ISquareCell
{
	private $borders = 0;

	private $borderTypes = [
		self::BORDER_RIGHT  => 0b0001,
		self::BORDER_BOTTOM => 0b0010,
		self::BORDER_LEFT   => 0b0100,
		self::BORDER_TOP    => 0b1000
	];

	public function set($borders)
	{
		$this->borders = $borders;
	}

	public function get()
	{
		return $this->borders;
	}

	public function addBorder($type)
	{
//		assert('array_key_exists($type, $this->borderTypes)');
		$this->borders |= $this->borderTypes[$type];
	}

	public function removeBorder($type)
	{
//		assert('array_key_exists($type, $this->borderTypes)');
		$this->borders &= (~$this->borderTypes[$type]);
	}

	public function hasBorder($type)
	{
//		assert('array_key_exists($type, $this->borderTypes)');
		return ($this->borders & $this->borderTypes[$type]) OR false;
	}
}

?>