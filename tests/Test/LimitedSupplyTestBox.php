<?php
/**
 * Box packing (3D bin packing, knapsack problem).
 *
 * @author Doug Wright
 */
declare(strict_types=1);

namespace Racem\BoxPacker\Test;

use Racem\BoxPacker\LimitedSupplyBox;

class LimitedSupplyTestBox extends TestBox implements LimitedSupplyBox
{
    /**
     * @var int
     */
    private $quantity;

    public function __construct(
        string $reference,
        string $type,
        int $outerWidth,
        int $outerLength,
        int $outerDepth,
        int $emptyWeight,
        int $innerWidth,
        int $innerLength,
        int $innerDepth,
        int $maxWeight,
        int $quantity
    ) {
        parent::__construct($reference, $type, $outerWidth, $outerLength, $outerDepth, $emptyWeight, $innerWidth, $innerLength, $innerDepth, $maxWeight);
        $this->quantity = $quantity;
        
    }

    public function getQuantityAvailable(): int
    {
        return $this->quantity;
    }
}
