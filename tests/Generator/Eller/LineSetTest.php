<?php

namespace MazeGenerator\Test;

class LineSetTest extends \PHPUnit_Framework_Testcase
{
	/**
	 * @var \MazeGenerator\Generator\Eller\ILineSet
	 */
	private static $line;

	public static function setUpBeforeClass()
	{
		$class  = new \ReflectionClass('\MazeGenerator\System\Factory');
		$method = $class->getMethod('getLineSet');
		$method->setAccessible(true);
		$factory = \MazeGenerator\System\Factory::getInstance();

		self::$line = $method->invoke($factory);
	}

	/**
	 * @covers \MazeGenerator\Generator\Eller\LineSet::setLine
	 * @covers \MazeGenerator\Generator\Eller\LineSet::createNewSet
	 * @covers \MazeGenerator\Generator\Eller\LineSet::getSetElementsPositions
	 */
	public function testTopLine()
	{
		self::$line->setLine(0);
		$positions = self::$line->getSetElementsPositions();
		$this->assertEquals(count($positions), 0);

		self::$line->createNewSet(0);
		self::$line->createNewSet(1);

		$this->assertFalse(self::$line->isSameSet(0, 1));
		$positions = self::$line->getSetElementsPositions();

		$set1 = current($positions);
		$set2 = next($positions);
		$this->assertEquals(count($set1), 1);
		$this->assertEquals(count($set2), 1);
		$this->assertEquals($set1[0] + 1, $set2[0]);
	}

	/**
	 * @depends testTopLine
	 */
	public function testCreateNewSetIfEmpty()
	{
		$positions = self::$line->getSetElementsPositions();

		self::$line->createNewSetIfEmpty(1);
		$this->assertEquals($positions, self::$line->getSetElementsPositions());

		self::$line->createNewSetIfEmpty(3);
		$positions2 = self::$line->getSetElementsPositions();
		$this->assertEquals(count($positions) + 1, count($positions2));
	}

	/**
	 * @depends testTopLine
	 */
	public function testCopyPreviousIfEmpty()
	{
		$positions = self::$line->getSetElementsPositions();

		self::$line->copyPreviousIfEmpty(1);
		$this->assertEquals($positions, self::$line->getSetElementsPositions());

		self::$line->copyPreviousIfEmpty(2);
		$positionsNew = self::$line->getSetElementsPositions();
		$this->assertEquals(count($positions), count($positionsNew));

		$addedToSets = 0;
		foreach ($positions as $setId => $ids) {
			if (count($positions[$setId]) < count($positionsNew[$setId])) {
				if (in_array(2, $positionsNew[$setId])) {
					$addedToSets++;
				} else {
					$this->assertTrue(false);
				}
			}
		}
		$this->assertEquals($addedToSets, 1);

		self::$line->copyPreviousIfEmpty(8);
		$positions = $positionsNew;
		$positionsNew = self::$line->getSetElementsPositions();
		$this->assertEquals(count($positions) + 1, count($positionsNew));
	}

	/**
	 * @depends testTopLine
	 * @depends testCreateNewSetIfEmpty
	 * @depends testCopyPreviousIfEmpty
	 */
	public function testIsSameSet()
	{
		$this->assertFalse(self::$line->isSameSet(0, 1));
		$this->assertTrue(self::$line->isSameSet(1, 2));
		$this->assertFalse(self::$line->isSameSet(2, 3));
		$this->assertFalse(self::$line->isSameSet(3, 4));
	}

	/**
	 * @depends testTopLine
	 * @depends testCreateNewSetIfEmpty
	 * @depends testCopyPreviousIfEmpty
	 */
	public function testCopyUpper()
	{
		$positionsTop = self::$line->getSetElementsPositions();

		self::$line->setLine(1);
		$positionsBottom = self::$line->getSetElementsPositions();
		$this->assertTrue(empty($positionsBottom));

		self::$line->copyUpper(0);
		self::$line->copyUpper(3);
		self::$line->copyUpper(1);
		self::$line->copyUpper(2);
		self::$line->copyUpper(8);

		$positionsBottom = self::$line->getSetElementsPositions();
		$this->assertEquals($positionsTop, $positionsBottom);
	}

	/**
	 * @depends testTopLine
	 * @depends testCreateNewSetIfEmpty
	 * @depends testCopyPreviousIfEmpty
	 * @depends testCopyUpper
	 * @dataProvider setsToMergeProvider
	 */
	public function testMergeSets($x1, $x2)
	{
		$positions = self::$line->getSetElementsPositions();
		$oldSetId = $newSetId = null;

		foreach ($positions as $setId => $ids) {
			if (in_array($x2, $ids)) {
				$newSetId = $setId;
			}
			if (in_array($x1, $ids)) {
				$oldSetId = $setId;
			}
		}

		self::$line->mergeSets($x1, $x2);
		$positionsNew = self::$line->getSetElementsPositions();

		if ($newSetId === $oldSetId) {
			$this->assertEquals($positions, $positionsNew);
		} else {
			$this->assertNotEquals($positions, $positionsNew);
			$this->assertFalse(isset($positionsNew[$oldSetId]));
			$this->assertTrue(in_array($x2, $positionsNew[$newSetId]));
		}
	}

	public function setsToMergeProvider()
	{
		return [
			[0, 3],
			[1, 2],
			[1, 3],
			[2, 3],
			[0, 1]
		];
	}

	/**
	 * @depends testMergeSets
	 */
	public function testSetLine()
	{
		$positions = self::$line->getSetElementsPositions();
		$this->assertNotEmpty($positions);

		self::$line->setLine(2);
		$positions = self::$line->getSetElementsPositions();
		$this->assertEmpty($positions);
	}
}