import OrderSchedulerOverride from './order-scheduler/index';
import OrderScheduleradress from './order-address/index';
import OrderSchedulerStartDate from './order-startdate/index';
import OrderSchedulerEndDate from './order-enddate/index';
import OrderSchedulerDays from './order-days/index';
import OrderSchedulerWeeks from './order-weeks/index';

window.PluginManager.register(
    'OrderSchedulerOverride',
    OrderSchedulerOverride,
    '[data-order-scheduler-button]'
);
window.PluginManager.register(
    'OrderScheduleradress',
    OrderScheduleradress,
    '[data-order-scheduler-address]'
);
window.PluginManager.register(
    'OrderSchedulerStartDate',
    OrderSchedulerStartDate,
    '[data-order-scheduler-startdate]'
);
window.PluginManager.register(
    'OrderSchedulerEndDate',
    OrderSchedulerEndDate,
    '[data-order-scheduler-enddate]'
);
window.PluginManager.register(
    'OrderSchedulerDays',
    OrderSchedulerDays,
    '[data-order-scheduler-days]'
);
window.PluginManager.register(
    'OrderSchedulerWeeks',
    OrderSchedulerWeeks,
    '[data-order-scheduler-weeks]'
);
