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
use Racem\BoxPacker\Rotation;

class THPackTestItem implements ConstrainedPlacementItem
{
    /**
     * @var string
     */
    private $description;

    /**
     * @var int
     */
    private $width;

    /**
     * @var int
     */
    private $length;

    /**
     * @var int
     */
    private $depth;

    /**
     * @var int
     */
    private $weight;

    /**
     * @var bool
     */
    private $widthAllowedVertical;

    /**
     * @var bool
     */
    private $lengthAllowedVertical;

    /**
     * @var bool
     */
    private $depthAllowedVertical;

    /**
     * TestItem constructor.
     */
    public function __construct(
        string $description,
        int $width,
        bool $widthAllowedVertical,
        int $length,
        bool $lengthAllowedVertical,
        int $depth,
        bool $depthAllowedVertical
    ) {
        $this->description = $description;
        $this->width = $width;
        $this->widthAllowedVertical = $widthAllowedVertical;
        $this->length = $length;
        $this->lengthAllowedVertical = $lengthAllowedVertical;
        $this->depth = $depth;
        $this->depthAllowedVertical = $depthAllowedVertical;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getWidth(): int
    {
        return $this->width;
    }

    public function getLength(): int
    {
        return $this->length;
    }

    public function getDepth(): int
    {
        return $this->depth;
    }

    public function getWeight(): int
    {
        return 0;
    }

    public function getAllowedRotation(): Rotation
    {
        return (!$this->widthAllowedVertical && !$this->lengthAllowedVertical && $this->depthAllowedVertical) ? Rotation::KeepFlat : Rotation::BestFit;
    }

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
        $ok = false;
        if ($depth === $this->width) {
            $ok = $ok || $this->widthAllowedVertical;
        }
        if ($depth === $this->length) {
            $ok = $ok || $this->lengthAllowedVertical;
        }
        if ($depth === $this->depth) {
            $ok = $ok || $this->depthAllowedVertical;
        }

        return $ok;
    }
}
