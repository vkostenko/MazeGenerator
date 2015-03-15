<?php
namespace MazeGenerator\Generator\Eller;

use MazeGenerator\Field\Cell\ISquareCell;
use \MazeGenerator\Field\ISquareField;

class Generator extends \MazeGenerator\Generator\AbstractGenerator
{
	/**
	 * @var ISquareField;
	 */
	protected $field;

	/**
	 * @var ILineSet;
	 */
	protected $line;

	protected $fieldWidth, $fieldHeight;

	public function __construct(ISquareField $field, ILineSet $lineSet)
	{
		parent::__construct($field);
		$this->line = $lineSet;
		$this->fieldWidth = $this->field->getWidth();
		$this->fieldHeight = $this->field->getHeight();
	}

	public function generateMaze()
	{
		$this->fillTopLine();
		for ($i = 1; $i < $this->fieldHeight; $i++) {
			$this->fillLine($i);
		}
		$this->fillBottomLine();

		return $this;
	}

	private function getRandomVerticalBorders()
	{
		$width = $this->fieldWidth - 2;
		if ($width <= 1) {
			return [];
		}
		$positions = new \SplFixedArray($width);
		$borders = array_rand($positions->toArray(), floor($width / 3));
		if (!is_array($borders)) {
			return [$borders];
		}
		asort($borders);

		return array_values($borders);
	}

	private function getRandomHorizontalBorders($positions)
	{
		shuffle($positions);

		return array_slice($positions, rand(1, count($positions) - 1));
	}

	private function setBorderBottoms($setPositions, $y)
	{
		$bottomBorders = [];
		$this->line->setLine($y + 1, $this->fieldWidth);

		foreach ($setPositions as $setId => $positions) {
			if (isset($positions[1])) {
				foreach ($this->getRandomHorizontalBorders($positions) as $x) {
					$this->field->addBorder($x, $y, ISquareCell::BORDER_BOTTOM);
					$bottomBorders[] = $x;
				}
			}
		}

		asort($bottomBorders);
		$bottomBorders = array_values($bottomBorders);
		$countBorders = count($bottomBorders);
		for ($i = 0, $b = 0; $i < $this->fieldWidth; $i++) {
			if ($b === $countBorders || $i !== $bottomBorders[$b]) {
				$this->line->copyUpper($i);
			} else {
				$b++;
			}
		}
	}

	private function fillTopLine()
	{
		$this->line->setLine(0, $this->fieldWidth);
		$borders = $this->getRandomVerticalBorders();
		$countBorders = count($borders);

		for ($x = 0, $b = 0, $y = 0; $x < $this->fieldWidth; $x++) {
			$this->line->copyPreviousIfEmpty($x);
			if ($b !== $countBorders && $x === $borders[$b]) {
				$b++;
				$this->line->createNewSet($x + 1);
				$this->field->addBorder($x, $y, ISquareCell::BORDER_RIGHT);
			}
		}

		$this->setBorderBottoms($this->line->getSetElementsPositions(), $y);
	}

	private function fillLine($y)
	{
		$borders = $this->getRandomVerticalBorders($y);
		$countBorders = count($borders);

		$prevHasBorder = false;
		for ($x = 0, $b = 0; $x < $this->fieldWidth; $x++) {
			$this->line->createNewSetIfEmpty($x);

			if ($x !== 0 && !$prevHasBorder) {
				if ($this->line->isSameSet($x, $x - 1)) {
					$this->field->addBorder($x - 1, $y, ISquareCell::BORDER_RIGHT);
				} else {
					$this->line->mergeSets($x, $x - 1);
				}
			}

			if ($b !== $countBorders && $x === $borders[$b]) {
				$b++;
				$this->field->addBorder($x, $y, ISquareCell::BORDER_RIGHT);
				$prevHasBorder = true;
			} else {
				$prevHasBorder = false;
			}
		}

		if ($y < $this->fieldHeight - 1) {
			$this->setBorderBottoms($this->line->getSetElementsPositions(), $y);
		}
	}

	private function fillBottomLine()
	{
		$y = $this->fieldHeight - 1;

		for ($x = 0; $x < $this->fieldWidth - 1; $x++) {
			if (!$this->line->isSameSet($x, $x + 1)) {
				$this->field->removeBorder($x, $y, ISquareCell::BORDER_RIGHT);
				$this->line->mergeSets($x, $x + 1);
			}
		}
	}
}


?>