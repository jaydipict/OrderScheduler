import { Component } from 'src/core/shopware';
import template from './sw-order-line-items-grid.html.twig';
import './sw-order-line-itms-grid.scss';
import deDE from './../../snippet/de-DE.json';
import enGB from './../../snippet/en-GB.json';

Component.override('sw-order-line-items-grid', {
    template,
    snippets: {
        'de-DE': deDE,
        'en-GB': enGB
    },
});
