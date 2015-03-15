<?php
namespace MazeGenerator\Test;

class AutoloadTest extends \PHPUnit_Framework_Testcase
{
	/**
	 * @expectedException \MazeGenerator\Exception\ApplicationException
	 */
	function testAutoloadException()
	{
		$className = 'MazeGenerator\..\someDirectory';
		\autoload($className);
	}

	function testAutoload()
	{
		$className = 'MazeGenerator\System\Factory';
		$this->assertTrue(\autoload($className));

		$className = 'MazeGenerator\System\WrongClass';
		$this->assertFalse(\autoload($className));
	}
}

?>