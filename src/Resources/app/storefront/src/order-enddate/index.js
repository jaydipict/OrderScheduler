import Plugin from 'src/plugin-system/plugin.class';

export default class OrderSchedulerEndDate extends Plugin {

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
            var endDate = document.querySelector('#endDate').value;

            let partsStartDate = startDate.split('-');
            let chkStartDate = new Date(partsStartDate[2], partsStartDate[1] - 1, partsStartDate[0]);
            let partsEndDate = endDate.split('-');
            let chkEndDate = new Date(partsEndDate[2], partsEndDate[1] - 1, partsEndDate[0]);

            if(endDate === ''){
                document.querySelector('.error-endDate').style.display = 'block';
            }else{
                document.querySelector('.error-endDate').style.display = 'none';
            }

            if(chkStartDate.getTime() > chkEndDate.getTime()) {
                document.querySelector('.error-endDateChk').style.display = 'block';
            }else{
                document.querySelector('.error-endDateChk').style.display = 'none';
            }

        })
    }
}
