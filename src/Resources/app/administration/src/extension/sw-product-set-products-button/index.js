import template from './sw-product-detail-set-product-button.html.twig';
import deDE from './../../snippet/de-DE.json';
import enGB from './../../snippet/en-GB.json';
const { Component } = Shopware;
const { Criteria } = Shopware.Data;

Component.override('sw-product-basic-form', {
    template,
    snippets: {
        'de-DE': deDE,
        'en-GB': enGB
    },
    inject: ['repositoryFactory'],
    data()
    {
    	return {
    		setProductData: null,
            setProduct: false,
    	}
    },
    mounted() {
        this.setProduct = this.product.extensions.setProduct && this.product.extensions.setProduct.active;
    },
    computed: {
    	setProductRepository() {
            return this.repositoryFactory.create('set_product');
        }
    },
    watch: {
        'setProduct'(active) {
            if (!this.product.extensions.setProduct) {
                this.product.extensions.setProduct = this.setProductRepository.create(Shopware.Context.api);
            }
            this.product.extensions.setProduct.active = active;
        }
    }
});
