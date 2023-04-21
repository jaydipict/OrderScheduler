<?php declare(strict_types=1);

namespace OrderScheduler\Core\Content\SetProduct;

use Shopware\Core\Framework\DataAbstractionLayer\EntityDefinition;
use Shopware\Core\Framework\DataAbstractionLayer\FieldCollection;
use Shopware\Core\Framework\DataAbstractionLayer\Field\CreatedAtField;
use Shopware\Core\Framework\DataAbstractionLayer\Field\FkField;
use Shopware\Core\Framework\DataAbstractionLayer\Field\Flag\PrimaryKey;
use Shopware\Core\Framework\DataAbstractionLayer\Field\Flag\Required;
use Shopware\Core\Framework\DataAbstractionLayer\Field\Flag\CascadeDelete;
use Shopware\Core\Framework\DataAbstractionLayer\Field\IdField;
use Shopware\Core\Framework\DataAbstractionLayer\Field\BoolField;
use Shopware\Core\Framework\DataAbstractionLayer\Field\OneToOneAssociationField;
use Shopware\Core\Framework\DataAbstractionLayer\Field\UpdatedAtField;
use Shopware\Core\Framework\DataAbstractionLayer\Field\ReferenceVersionField;
use Shopware\Core\Content\Product\ProductDefinition as BaseProductDefinition;

/**
 * Class SetProductDefinition
*/
class SetProductDefinition extends EntityDefinition
{

    public const ENTITY_NAME = 'set_product';

    public function getEntityName(): string
    {
        return static::ENTITY_NAME;
    }

    public function getEntityClass(): string
    {
        return SetProductEntity::class;
    }

    public function getCollectionClass(): string
    {
        return SetProductCollection::class;
    }

    protected function defineFields(): FieldCollection
    {
        return new FieldCollection([
            (new IdField('id','id'))->addFlags(new PrimaryKey(),new Required()),
            (new FkField('product_id','productId',BaseProductDefinition::class))->addFlags(new Required(), new CascadeDelete()),
            (new ReferenceVersionField(BaseProductDefinition::class))->addFlags(new PrimaryKey(), new Required()),
            new BoolField('active', 'active'),
            new CreatedAtField(),
            new UpdatedAtField(),
            new OneToOneAssociationField('product', 'product_id', 'id',BaseProductDefinition::class,false)
        ]);
    }
}
