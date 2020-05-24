define([
    'uiComponent',
    'jquery',
    'Magento_Ui/js/modal/confirm',
    'MageMastery_Todo/js/service/task',
    'MageMastery_Todo/js/model/loader'
], function (Component, $, modal, taskService, loader) {
    'use strict';

    return Component.extend({
        defaults: {
            buttonSelector: '#add-new-task-button',
            newTaskLabel: '',
            tasks: []
        },

        initObservable: function () {
            this._super().observe(['tasks', 'newTaskLabel']);

            var self = this;
            taskService.getList().then(function (tasks) {
                self.tasks(tasks);
                return tasks;
            });

            return this;
        },

        switchStatus: function (data, event) {
            const taskid = $(event.target).data('id');

            var items = this.tasks().map(function (task) {
                if (task.task_id === taskid) {
                    task.status = task.status === 'open' ? 'complete' : 'open';
                    taskService.update(taskid, task.status);
                }

                return task;
            });

            this.tasks(items);
        },

        deleteTask: function (taskId) {
            var self = this;

            modal({
                content: 'Are you sure you want to delete the task?',
                actions: {
                    confirm: function () {
                        var tasks = [];

                        if (self.tasks().length === 1) {
                            self.tasks(tasks);

                            return;
                        }

                        taskService.delete(self.tasks().find(function (task) {
                            if (task.task_id === taskId) {
                                return task;
                            }
                        }));

                        self.tasks().forEach(function (task) {
                            if (task.task_id !== taskId) {
                                tasks.push(task);
                            }
                        });

                        self.tasks(tasks);
                    }
                }
            });
        },

        addTask: function () {
            const self = this;

            var task = {
                label: this.newTaskLabel(),
                status: 'open'
            };

            loader.startLoader();

            taskService.create(task)
                .then(function (taskId) {
                    task.task_id = taskId;
                    self.tasks.push(task);
                    self.newTaskLabel('');
                })
                .finally(function () {
                    loader.stopLoader();
                });
        },

        checkKey: function (data, event) {
            if (event.keyCode === 13) {
                event.preventDefault();
                $(this.buttonSelector).click();
            }
        }
    });
});
