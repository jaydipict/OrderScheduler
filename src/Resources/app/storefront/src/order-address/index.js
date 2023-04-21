import Plugin from 'src/plugin-system/plugin.class';

export default class OrderScheduleradress extends Plugin {

    /**
     * Plugin constructor. Finds the necessary elements from the DOM and starts the plugin.
     *
     * @constructor
     * @returns {void}
     */
    init() {
        this._registerEvents();
    }
    _registerEvents(){
        this.el.addEventListener('change', e => {
            var oderAddress = document.querySelector('#oderAddress').value;
            if(oderAddress === ''){
                document.querySelector('.error-address').style.display = 'block';
            }else {
                document.querySelector('.error-address').style.display = 'none';
            }
        })
    }
}
