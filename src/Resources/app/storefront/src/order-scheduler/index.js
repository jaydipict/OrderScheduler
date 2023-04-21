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
            this.el.addEventListener('click', e => {
                e.preventDefault();
                let oderAddress = document.querySelector('#oderAddress').value;
                let startDate = document.querySelector('#startDate').value;
                let endDate = document.querySelector('#endDate').value;
                let orderdays = document.querySelectorAll('input[name=\'option[day][]\']:checked');
                let weeks = document.querySelector('#weeks').value;

                let partsStartDate = startDate.split('-');
                let chkStartDate = new Date(partsStartDate[2], partsStartDate[1] - 1, partsStartDate[0]);
                let partsEndDate = endDate.split('-');
                let chkEndDate = new Date(partsEndDate[2], partsEndDate[1] - 1, partsEndDate[0]);

                if(oderAddress === ''){
                    document.querySelector('.error-address').style.display = 'block';
                }else if(startDate === ''){
                    document.querySelector('.error-startDate').style.display = 'block';
                }else if(endDate === ''){
                    document.querySelector('.error-endDate').style.display = 'block';
                }else if(chkStartDate.getTime() > chkEndDate.getTime()) {
                    document.querySelector('.error-endDateChk').style.display = 'block';
                }else if(orderdays.length === 0){
                    document.querySelector('.error-orderdays').style.display = 'block';
                }else if(weeks === ''){
                    document.querySelector('.error-weeks').style.display = 'block';
                }else{
                    document.querySelector('.error-address').style.display = 'none';
                    document.querySelector('.error-startDate').style.display = 'none';
                    document.querySelector('.error-endDate').style.display = 'none';
                    document.querySelector('.error-endDateChk').style.display = 'none';
                    document.querySelector('.error-orderdays').style.display = 'none';
                    document.querySelector('.error-weeks').style.display = 'none';
                    const container = document
                        .getElementById("customAddToCart");
                    const tmpl = document
                        .getElementById("scheduler-button")
                        .content.cloneNode(true);
                    container.querySelector('.modal-footer').appendChild(tmpl);
                    container.querySelector('.realButton').click();
                    container.querySelector('.realButton').remove();
                }
            })
        }
}
