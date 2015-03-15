<?php

namespace MazeGenerator\Generator\Eller;

interface ILineSet
{
	public function setLine($y, $width);

	public function createNewSet($x);

	public function createNewSetIfEmpty($x);

	public function copyPreviousIfEmpty($x);

	public function getSetElementsPositions();

	public function copyUpper($x);

	public function isSameSet($x1, $x2);

	public function mergeSets($x1, $x2);
}