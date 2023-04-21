import template from './sw-product-detail.html.twig';
const { Component } = Shopware;
const { Criteria } = Shopware.Data;

Component.override('sw-product-detail', {
    template,
    computed: {
        productCriteria() {
            const criteria = this.$super('productCriteria');
            criteria.addAssociation('setProduct');
            return criteria;
        },
    }
});
