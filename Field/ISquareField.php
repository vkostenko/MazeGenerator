<?php
namespace MazeGenerator\Field;

interface ISquareField extends IField
{
    public function __construct(\MazeGenerator\Field\Cell\ISquareCell $cell, $width, $height);

    public function getWidth();

    public function getHeight();

	public function addBorder($x, $y, $type);

	public function removeBorder($x, $y, $type);

	public function hasBorder($x, $y, $type);
}