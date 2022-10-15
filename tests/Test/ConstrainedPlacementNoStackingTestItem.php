<?php
/**
 * Box packing (3D bin packing, knapsack problem).
 *
 * @author Doug Wright
 */
declare(strict_types=1);

namespace Racem\BoxPacker\Test;

use Racem\BoxPacker\Box;
use Racem\BoxPacker\ConstrainedPlacementItem;
use Racem\BoxPacker\PackedBox;
use Racem\BoxPacker\PackedItem;

use function array_filter;
use function iterator_to_array;

class ConstrainedPlacementNoStackingTestItem extends TestItem implements ConstrainedPlacementItem
{
    /**
     * Hook for user implementation of item-specific constraints, e.g. max <x> batteries per box.
     */
    public function canBePacked(
        PackedBox $packedBox,
        int $proposedX,
        int $proposedY,
        int $proposedZ,
        int $width,
        int $length,
        int $depth
    ): bool {
        $alreadyPackedType = array_filter(
            iterator_to_array($packedBox->getItems(), false),
            fn (PackedItem $item) => $item->getItem()->getDescription() === $this->getDescription()
        );

        /** @var PackedItem $alreadyPacked */
        foreach ($alreadyPackedType as $alreadyPacked) {
            if (
                $alreadyPacked->getZ() + $alreadyPacked->getDepth() === $proposedZ &&
                $proposedX >= $alreadyPacked->getX() && $proposedX <= ($alreadyPacked->getX() + $alreadyPacked->getWidth()) &&
                $proposedY >= $alreadyPacked->getY() && $proposedY <= ($alreadyPacked->getY() + $alreadyPacked->getLength())) {
                return false;
            }
        }

        return true;
    }
}
