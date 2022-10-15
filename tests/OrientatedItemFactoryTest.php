<?php
/**
 * Box packing (3D bin packing, knapsack problem).
 *
 * @author Doug Wright
 */
declare(strict_types=1);

namespace Racem\BoxPacker;

use Racem\BoxPacker\Test\TestBox;
use Racem\BoxPacker\Test\TestItem;
use PHPUnit\Framework\TestCase;

use const PHP_INT_MAX;

class OrientatedItemFactoryTest extends TestCase
{
    public function testAllRotations(): void
    {
        $box = new TestBox('Box', PHP_INT_MAX, PHP_INT_MAX, PHP_INT_MAX, 0, PHP_INT_MAX, PHP_INT_MAX, PHP_INT_MAX, PHP_INT_MAX);
        $factory = new OrientatedItemFactory($box);

        $item = new TestItem('Test', 1, 2, 3, 4, Rotation::BestFit);
        $orientations = $factory->getPossibleOrientations($item, null, $box->getInnerWidth(), $box->getInnerLength(), $box->getInnerDepth(), 0, 0, 0, new PackedItemList());

        self::assertCount(6, $orientations);

        self::assertEquals(1, $orientations[0]->getWidth());
        self::assertEquals(2, $orientations[0]->getLength());
        self::assertEquals(3, $orientations[0]->getDepth());

        self::assertEquals(2, $orientations[1]->getWidth());
        self::assertEquals(1, $orientations[1]->getLength());
        self::assertEquals(3, $orientations[1]->getDepth());

        self::assertEquals(1, $orientations[2]->getWidth());
        self::assertEquals(3, $orientations[2]->getLength());
        self::assertEquals(2, $orientations[2]->getDepth());

        self::assertEquals(2, $orientations[3]->getWidth());
        self::assertEquals(3, $orientations[3]->getLength());
        self::assertEquals(1, $orientations[3]->getDepth());

        self::assertEquals(3, $orientations[4]->getWidth());
        self::assertEquals(1, $orientations[4]->getLength());
        self::assertEquals(2, $orientations[4]->getDepth());

        self::assertEquals(3, $orientations[5]->getWidth());
        self::assertEquals(2, $orientations[5]->getLength());
        self::assertEquals(1, $orientations[5]->getDepth());
    }

    public function testKeepFlat(): void
    {
        $box = new TestBox('Box', PHP_INT_MAX, PHP_INT_MAX, PHP_INT_MAX, 0, PHP_INT_MAX, PHP_INT_MAX, PHP_INT_MAX, PHP_INT_MAX);
        $factory = new OrientatedItemFactory($box);

        $item = new TestItem('Test', 1, 2, 3, 4, Rotation::KeepFlat);
        $orientations = $factory->getPossibleOrientations($item, null, $box->getInnerWidth(), $box->getInnerLength(), $box->getInnerDepth(), 0, 0, 0, new PackedItemList());

        self::assertCount(2, $orientations);

        self::assertEquals(1, $orientations[0]->getWidth());
        self::assertEquals(2, $orientations[0]->getLength());
        self::assertEquals(3, $orientations[0]->getDepth());

        self::assertEquals(2, $orientations[1]->getWidth());
        self::assertEquals(1, $orientations[1]->getLength());
        self::assertEquals(3, $orientations[1]->getDepth());
    }

    public function testNoRotate(): void
    {
        $box = new TestBox('Box', PHP_INT_MAX, PHP_INT_MAX, PHP_INT_MAX, 0, PHP_INT_MAX, PHP_INT_MAX, PHP_INT_MAX, PHP_INT_MAX);
        $factory = new OrientatedItemFactory($box);

        $item = new TestItem('Test', 1, 2, 3, 4, Rotation::Never);
        $orientations = $factory->getPossibleOrientations($item, null, $box->getInnerWidth(), $box->getInnerLength(), $box->getInnerDepth(), 0, 0, 0, new PackedItemList());

        self::assertCount(1, $orientations);

        self::assertEquals(1, $orientations[0]->getWidth());
        self::assertEquals(2, $orientations[0]->getLength());
        self::assertEquals(3, $orientations[0]->getDepth());
    }
}
