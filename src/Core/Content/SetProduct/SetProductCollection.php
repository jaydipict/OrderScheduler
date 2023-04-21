<?php declare(strict_types=1);

namespace OrderScheduler\Core\Content\SetProduct;
use Shopware\Core\Framework\DataAbstractionLayer\EntityCollection;

/**
 * Class SetProductCollection
 * @package OrderScheduler\Core\Content\SetProduct
*/
class SetProductCollection extends EntityCollection
{
    protected function getExpectedClass(): string
    {
        return SetProductEntity::class;
    }
}
