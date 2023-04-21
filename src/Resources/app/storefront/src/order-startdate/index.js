import Plugin from 'src/plugin-system/plugin.class';

export default class OrderSchedulerStartDate extends Plugin {

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
            var startDate = document.querySelector('#startDate').value;
            if(startDate === ''){
                document.querySelector('.error-startDate').style.display = 'block';
            }else {
                document.querySelector('.error-startDate').style.display = 'none';
            }
        })
    }
}
