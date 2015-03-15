<?php

namespace MazeGenerator\Generator;

use \MazeGenerator\Field\IField;

abstract class AbstractGenerator
{
	protected $field;

	/**
	 * @return AbstractGenerator
	 */
	abstract public function generateMaze();

	public function __construct(IField $field)
	{
		$this->field = $field;
	}

	/**
	 * @return IField
	 */
	public function getField()
	{
		return $this->field;
	}
}
