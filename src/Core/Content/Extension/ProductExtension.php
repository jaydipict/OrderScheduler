<?php declare(strict_types=1);

namespace OrderScheduler\Core\Content\Extension;

use Shopware\Core\Content\Product\ProductDefinition;
use Shopware\Core\Framework\DataAbstractionLayer\EntityExtension;
use Shopware\Core\Framework\DataAbstractionLayer\Field\Flag\Inherited;
use Shopware\Core\Framework\DataAbstractionLayer\Field\OneToManyAssociationField;
use Shopware\Core\Framework\DataAbstractionLayer\Field\BoolField;
use Shopware\Core\Framework\DataAbstractionLayer\FieldCollection;
use Shopware\Core\Framework\DataAbstractionLayer\Field\OneToOneAssociationField;
use Shopware\Core\Framework\DataAbstractionLayer\Field\ManyToManyAssociationField;
use Shopware\Core\Framework\DataAbstractionLayer\Field\Flag\CascadeDelete;
use OrderScheduler\Core\Content\SetProduct\SetProductDefinition;
use Shopware\Core\Framework\DataAbstractionLayer\Field\Flag\Extension;

class ProductExtension extends EntityExtension
{
    public function extendFields(FieldCollection $collection): void
    {
       $collection->add(
            (new OneToOneAssociationField(
                'setProduct',
                'id',
                'product_id',
                SetProductDefinition::class
            ))->addFlags(new CascadeDelete())
        );
    }
    public function getDefinitionClass(): string
    {
        return ProductDefinition::class;
    }
}
