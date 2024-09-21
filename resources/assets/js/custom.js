/**
 * Template for one task output
 *
 * @param task
 * @returns {string}
 */
function taskItemTemplate(task) {

    const titleClass = task.status == 1 ? 'text-line-through' : '';

    const checkBtn = task.status == 1 ? `
        <button class="btn btn-secondary btn-sm mr-1 mb-1 restoreBtn" data-id="${task.id}">
            <i class="fas fa-undo"></i> 
        </button>
        ` : `
        <button class="btn btn-success btn-sm mr-1 mb-1 disableBtn" data-id="${task.id}">
            <i class="fas fa-check"></i>
        </button>`;

    return `
        <li class="list-group-item">
            <div class="row">
                <div class="col-12">
                    <h5 class="mb-1 ${titleClass}"">${task.title}</h5>
                    <p class="mb-0">${task.description}</p>
                    <div class="small">${task.created_at}</div>
                </div>
                <div class="col-12 text-left pt-2">
                    ${checkBtn}
                    <button class="btn btn-warning btn-sm mr-1 mb-1 btn-edit" data-id="${task.id}" data-toggle="modal" data-target="#editTaskModal">
                        <i class="fas fa-edit"></i>
                    </button>
                    <button class="btn btn-danger btn-sm mb-1 btn-delete" data-id="${task.id}">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
            </div>
        </li>
    `;
}

/**
 * Call API to toggle task status
 *
 * @param taskId
 * @param newStatus
 * @param taskElement
 * @param button
 */
function changeTaskStatus(taskId, newStatus, taskElement, button) {
    $.ajax({
        url: '/api/v1/tasks/' + taskId + '/toggle-status',
        method: 'PUT',
        data: {
            status: newStatus,
            _token: $('meta[name="csrf-token"]').attr('content')
        },
        beforeSend: function() {
            button.prop('disabled', true);
        },
        complete: function() {
            button.prop('disabled', false);
        },
        success: function(response) {
            if (response.success) {
                taskElement.replaceWith(taskItemTemplate(response.task));
            }
        },
        error: function(response) {
            console.log('Помилка при зміні статусу завдання:', response);
        }
    });
}

// Get tasks list. Set as global for accessing from the page
window.loadTasks = function() {

    $('#loader').show();
    $('#taskList').hide();

    $.ajax({
        url: '/api/v1/get-tasks-list',
        method: 'GET',
        success: function(response) {

            $('#loader').hide();
            $('#taskList').show();

            if (response.success) {
                response.tasks.forEach(function(task) {
                    $('#taskList').append(taskItemTemplate(task));
                });
            }
        },
        error: function(response) {
            console.log('Error retrieving tasks: ', response);

            $('#loader').hide();
            $('#taskList').show();
        }
    });
};

$(document).ready(function() {

    $('#addTaskButton').on('click', function() {
        $(this).hide();  // hide button
        $('#taskForm').show();  // show form
    });

    $('#cancelTaskButton').on('click', function() {
        $('#taskForm').hide();  // hide form
        $('#addTaskButton').show();  // show button
    });

    // Create new task
    $('#taskForm').on('submit', function(event) {
        event.preventDefault();

        let taskTitle = $('#taskTitle').val();
        let taskDescription = $('#taskDescription').val();
        let submitButton = $(this).find('button[type="submit"]');

        $.ajax({
            url: '/api/v1/tasks',
            method: 'POST',
            data: {
                title: taskTitle,
                description: taskDescription,
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            beforeSend: function() {
                submitButton.prop('disabled', true);
            },
            complete: function() {
                submitButton.prop('disabled', false);
            },
            success: function(response) {
                if (response.success) {
                    $('#taskList').prepend(taskItemTemplate(response.task));
                    $('#taskForm')[0].reset();
                }
            },
            error: function(response) {
                console.log('Error creating task:', response);
            }
        });
    });

    // Remove the task
    $(document).on('click', '.btn-delete', function() {
        let taskId = $(this).data('id');
        let taskElement = $(this).closest('li');
        let deleteButton = $(this);

        if (confirm('Are you sure you want to delete this task?')) {
            $.ajax({
                url: '/api/v1/tasks/' + taskId,
                method: 'DELETE',
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                beforeSend: function() {
                    deleteButton.prop('disabled', true);
                },
                complete: function() {
                    deleteButton.prop('disabled', false);
                },
                success: function(response) {
                    if (response.success) {
                        taskElement.remove();
                    } else {
                        alert('Error deleting task.');
                    }
                },
                error: function(response) {
                    console.log('Error deleting task:', response);
                }
            });
        }
    });

    // Before Task edit popup opened
    $(document).on('click', '.btn-edit', function() {

        let currentTaskId = $(this).data('id');
        let editButton = $(this);

        $('#editTaskModal').attr('data-task-id', currentTaskId);

        $.ajax({
            url: '/api/v1/tasks/' + currentTaskId,
            method: 'GET',
            beforeSend: function() {
                editButton.prop('disabled', true);
            },
            complete: function() {
                editButton.prop('disabled', false);
            },
            success: function(response) {
                if (response.success) {
                    $('#editTaskTitle').val(response.task.title);
                    $('#editTaskDescription').val(response.task.description);
                    $('#editTaskStatus').val(response.task.status);
                }
            },
            error: function(response) {
                console.log('Error retrieving task data:', response);
            }
        });
    });

    // Update the task
    $('#editTaskForm').on('submit', function(event) {
        event.preventDefault();

        let updatedTitle = $('#editTaskTitle').val();
        let updatedDescription = $('#editTaskDescription').val();
        let updatedStatus = $('#editTaskStatus').val();
        let submitButton = $(this).find('button[type="submit"]');
        let currentTaskId = $('#editTaskModal').attr('data-task-id');

        $.ajax({
            url: '/api/v1/tasks/' + currentTaskId,
            method: 'PUT',
            data: {
                title: updatedTitle,
                description: updatedDescription,
                status: updatedStatus,
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            beforeSend: function() {
                submitButton.prop('disabled', true);
            },
            complete: function() {
                submitButton.prop('disabled', false);
            },
            success: function(response) {
                if (response.success) {
                    let taskElement = $('button[data-id="' + currentTaskId + '"]').closest('li');
                    taskElement.replaceWith(taskItemTemplate(response.task));
                    $('#editTaskModal').modal('hide');
                }
            },
            error: function(response) {
                console.log('Error updating task:', response);
            }
        });
    });

    // Toggle the Task
    $(document).on('click', '.restoreBtn, .disableBtn', function() {
        let taskId = $(this).data('id');
        let taskElement = $(this).closest('li');
        let newStatus = $(this).hasClass('restoreBtn') ? 0 : 1;
        let button = $(this);

        changeTaskStatus(taskId, newStatus, taskElement, button);
    });

});

