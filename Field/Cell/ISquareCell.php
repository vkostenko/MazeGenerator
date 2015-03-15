<?php
namespace MazeGenerator\Field\Cell;

interface ISquareCell
{
	const BORDER_TOP = 1;
	const BORDER_RIGHT = 2;
	const BORDER_BOTTOM = 3;
	const BORDER_LEFT = 4;

	public function set($borders);

	public function get();

	public function addBorder($type);

	public function removeBorder($type);

	public function hasBorder($type);
}

?>