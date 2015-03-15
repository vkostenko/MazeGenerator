<?php

namespace MazeGenerator\Output\SquareField;

class Html
{
	private $field;

	public function __construct (\MazeGenerator\Output\SquareField\Decorator\IHtml $field)
	{
		$this->field = $field;
	}

	public function out()
	{
		$fieldHeight = $this->field->getHeight();
		$fieldWidth = $this->field->getWidth();

		echo '<style>
                td { padding:2px 10px; text-align:center; vertical-align:middle; background-color:#efe; }
                .top { border-top: 2px solid #000; }
                .right { border-right: 2px solid #000; }
                .bottom { border-bottom: 2px solid #000; }
                .left { border-left: 2px solid #000; }
        </style>';
		echo '<table cellspacing="3" cellpadding="3" border="0">';

		for ($y = 0; $y < $fieldHeight; $y++) {
			echo '<tr>';
			for ($x = 0; $x < $fieldWidth; $x++) {
				echo '<td class="'.$this->field->getClasses($x, $y).'">&nbsp;</td>';
			}
			echo '</tr>';
		}

		echo '</table>';
	}
}