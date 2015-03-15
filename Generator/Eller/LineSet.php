<?php

namespace MazeGenerator\Generator\Eller;

use MazeGenerator\System\tSingleton;

class LineSet implements ILineSet
{
    use tSingleton;

    private $maxSetId = 0,
            $cellSetIds = [],
			$lineWidth;
    private $y = 0;

	private $sets;

    public function setLine($y, $width) {
	    $this->sets = [];
	    $this->lineWidth = $width;
        if (isset($this->cellSetIds[$y-2])) {
            unset($this->cellSetIds[$y-2]);
        }
        if (!isset($this->cellSetIds[$y])) {
            $this->cellSetIds[$y] = new \SplFixedArray($width);
        }
        $this->y = $y;
    }

    public function createNewSet($x)
    {
        $this->cellSetIds[$this->y][$x] = ++$this->maxSetId;
	    $this->sets[$this->maxSetId][] = $x;
        return $this->cellSetIds[$this->y][$x];
    }

    public function createNewSetIfEmpty($x)
    {
        if (!isset($this->cellSetIds[$this->y][$x])) {
            $this->cellSetIds[$this->y][$x] = ++$this->maxSetId;
	        $this->sets[$this->maxSetId][] = $x;
        }
        return $this->cellSetIds[$this->y][$x];
    }

    public function copyPreviousIfEmpty($x)
    {
        if (!isset($this->cellSetIds[$this->y][$x])) {
            if (isset($this->cellSetIds[$this->y][$x-1])) {
	            $this->sets[$this->maxSetId][] = $x;
                $this->cellSetIds[$this->y][$x] = $this->cellSetIds[$this->y][$x-1];
            } else {
                $this->createNewSet($x, $this->y);
            }
        }

        return $this->cellSetIds[$this->y][$x];
    }

    public function getSetElementsPositions()
    {
        $positions = [];
        foreach ($this->cellSetIds[$this->y] as $x => $setId) {
            $positions[$setId][] = $x;
        }
        return $positions;
    }

    public function copyUpper($x)
    {
        $this->cellSetIds[$this->y][$x] = $this->cellSetIds[$this->y-1][$x];
	    $this->sets[$this->cellSetIds[$this->y][$x]][] = $x;
    }

    public function isSameSet($x1, $x2)
    {
        if (!isset($this->cellSetIds[$this->y][$x2])) {
            return false;
        }
        return $this->cellSetIds[$this->y][$x1] === $this->cellSetIds[$this->y][$x2];
    }

    public function mergeSets($x1, $x2)
    {
	    $valueNew = $this->cellSetIds[$this->y][$x2];
	    $valueOld = $this->cellSetIds[$this->y][$x1];

	    foreach ($this->sets[$valueOld] as $x) {
		    $this->sets[$valueNew][] = $x;
		    $this->cellSetIds[$this->y][$x] = $valueNew;
	    }
	    unset($this->sets[$valueOld]);
    }

}