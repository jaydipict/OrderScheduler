import Plugin from 'src/plugin-system/plugin.class';

export default class OrderSchedulerWeeks extends Plugin {

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
            var weeks = document.querySelector('#weeks').value;
            if(weeks.length === 0){
                document.querySelector('.error-weeks').style.display = 'block';
            }else {
                document.querySelector('.error-weeks').style.display = 'none';
            }
        })
    }
}
