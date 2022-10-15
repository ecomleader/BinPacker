<?php
/**
 * Box packing (3D bin packing, knapsack problem).
 *
 * @author Doug Wright
 */
declare(strict_types=1);

use Racem\BinPacker\Item;
use Racem\BinPacker\ItemList;
use Racem\BinPacker\Packer;
use PHPUnit\Framework\Assert;

/**
 * Defines application features from the specific context.
 */
class InfalliblePackerContext extends PackerContext
{
    protected ItemList $unpackedItemList;

    /**
     * @When I do an infallible packing
     */
    public function iDoAnInfalliblePacking(): void
    {
        $packer = new Packer();
        $packer->throwOnUnpackableItem(false);
        $packer->setBoxes($this->boxList);
        $packer->setItems($this->itemList);
        $this->packedBoxList = $packer->pack();
        $this->unpackedItemList = $packer->getUnpackedItems();
    }

    /**
     * @Then /^the unpacked item list should have (\d+) items of type "([^"]+)"$/
     */
    public function theUnpackedItemListShouldHaveItems(
        $qty,
        $itemType
    ): void {
        $foundItems = 0;

        foreach ($this->unpackedItemList as $unpackedItem) {
            if ($unpackedItem->getDescription() === $itemType) {
                ++$foundItems;
            }
        }

        Assert::assertEquals($qty, $foundItems);
    }
}
