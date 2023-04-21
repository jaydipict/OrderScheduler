<?php declare(strict_types=1);

namespace OrderScheduler\Service;

use Shopware\Core\Checkout\Cart\LineItem\LineItem;
use Shopware\Core\Checkout\Cart\LineItemFactoryHandler\LineItemFactoryInterface;
use Shopware\Core\System\SalesChannel\SalesChannelContext;

class CustomCartHandler implements LineItemFactoryInterface
{
    public function supports(string $type): bool
    {
        return $type === 'product';
    }

    public function create(array $data, SalesChannelContext $context): LineItem
    {

        return new LineItem((string) $data['referencedId'], LineItem::PRODUCT_LINE_ITEM_TYPE, (string) $data['referencedId'] ?? null, (int) $data['quantity']);
    }

    public function update(LineItem $lineItem, array $data, SalesChannelContext $context): void
    {
        if (isset($data['referencedId'])) {
            $lineItem->setReferencedId($data['referencedId']);
        }
    }
}
