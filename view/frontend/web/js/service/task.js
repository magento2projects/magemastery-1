define(['mage/storage'], function (storage) {
    'use strict';

    return {
        getList: function () {
            storage.get('rest/V1/customer/todo/tasks')
        }
    };
});
