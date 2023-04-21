import Plugin from 'src/plugin-system/plugin.class';

export default class OrderSchedulerDays extends Plugin {

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
        this.el.addEventListener('click', e => {
            var orderdays = document.querySelectorAll('input[name=\'option[day][]\']:checked');
            if(orderdays.length === 0){
                document.querySelector('.error-orderdays').style.display = 'block';
            }else {
                document.querySelector('.error-orderdays').style.display = 'none';
            }
        })
    }
}
