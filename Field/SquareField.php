<?php
namespace MazeGenerator\Field;

use \MazeGenerator\Field\Cell\ISquareCell;

class SquareField implements ISquareField
{
    /**
     * Size of field
     */
    private $width = 0,
            $height = 0,
			$cell,
			$posX, $posY;

    /**
     * @var \SplFixedArray[]
     */
    private $values = [];

    public function __construct(ISquareCell $cell, $width, $height)
    {
        $this->width = max(min($width, 1000), 2);
        $this->height = max(min($height, 1000), 2);

	    /*
	     * Working directly with $this->values instead of ISquareCell object, makes maze generation approximately 30% faster
	     * Easiest way to do so: comment all lines starting with "$this->cell" and uncomment all starting with "$this->values" in this class
	     */
	    $this->cell = $cell;

	    $this->values = new \SplFixedArray($this->width * $this->height);
        $countValues = $this->width * $this->height;
        for ($i = 0; $i < $countValues; $i++) {
            $this->values[$i] = 0;
        }

	    $this->addRoundBorder();
    }

    public function getWidth()
    {
        return $this->width;
    }

    public function getHeight()
    {
        return $this->height;
    }

	/**
	 * @param $x
	 * @param $y
	 *
	 * @return ISquareCell
	 */
	private function cell($x, $y)
	{
		if ($x != $this->posX || $y != $this->posY) {
			$this->values[$this->width * $this->posY + $this->posX] = $this->cell->get();
			$this->posX = $x;
			$this->posY = $y;
		}
		$this->cell->set($this->values[$this->width * $y + $x]);
		return $this->cell;
	}

    private function addRoundBorder()
    {
        for ($x = 0; $x < $this->width; $x++) {
	        $this->cell($x, 0)->addBorder(ISquareCell::BORDER_TOP);
	        $this->cell($x, $this->height - 1)->addBorder(ISquareCell::BORDER_BOTTOM);
//            $this->values[$x] = $this->borderTypes[ISquareCell::BORDER_TOP];
//            $this->values[$this->height * $this->width - $x - 1] = $this->borderTypes[ISquareCell::BORDER_BOTTOM];
        }
        for ($y = 0; $y < $this->height; $y++) {
	        if ($y > 0) {
		        $this->cell(0, $y)->addBorder(ISquareCell::BORDER_LEFT);
//		        $this->values[$this->width * $y] |= $this->borderTypes[ISquareCell::BORDER_LEFT];
	        }
	        if ($y != $this->height - 1) {
		        $this->cell($this->width - 1, $y)->addBorder(ISquareCell::BORDER_RIGHT);
//		        $this->values[$this->width * $y + $this->width - 1] |= $this->borderTypes[ISquareCell::BORDER_RIGHT];
	        }
        }
    }

    public function addBorder($x, $y, $type)
    {
	    $this->cell($x, $y)->addBorder($type);
//        $this->values[$this->width * $y + $x] |= $this->borderTypes[$type];
    }

    public function removeBorder($x, $y, $type)
    {
	    $this->cell($x, $y)->removeBorder($type);
//        $this->values[$this->width * $y + $x] &= (~$this->borderTypes[$type]);
    }

    public function hasBorder($x, $y, $type)
    {
	    return $this->cell($x, $y)->hasBorder($type);
//        return ($this->values[$this->width * $y + $x] & $this->borderTypes[$type]) OR false;
    }

}

?>