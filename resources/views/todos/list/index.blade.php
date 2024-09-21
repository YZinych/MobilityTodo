<?php

use App\User;

/**
 * @var $users User[]
 */
?>

@extends('todos.layouts.layout')

@section('content')

    <!-- Begin page content -->
    <main role="main" class="flex-shrink-0">
        <div class="container">

            <div class="row justify-content-center">
                <div class="col-md-8">
                    <h2 class="text-center">To-Do List</h2>

                    <button id="addTaskButton" class="btn btn-primary btn-block">
                        <i class="fas fa-plus"></i> Додати нове завдання
                    </button>

                    <form id="taskForm" style="display: none;" class="mt-3">
                        <div class="form-group">
                            <input type="text" class="form-control" id="taskTitle" placeholder="Введіть назву задачі" required>
                        </div>
                        <div class="form-group">
                            <textarea class="form-control" id="taskDescription" rows="3" placeholder="Опис задачі"></textarea>
                        </div>
                        <div class="d-flex justify-content-between">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-check"></i> Створити задачу
                            </button>
                            <button type="button" id="cancelTaskButton" class="btn btn-secondary">
                                <i class="fas fa-times"></i> Відмінити
                            </button>
                        </div>
                    </form>

                    <div id="loader" style="display: none;">
                        <div class="spinner-border text-primary" role="status">
                            <span class="sr-only">Loading...</span>
                        </div>
                    </div>
                    <ul class="list-group mt-4" id="taskList"></ul>
                </div>
            </div>

        </div>
    </main>
    <!-- End page content -->

    <!-- Modal Window -->
    <div class="modal fade" id="editTaskModal" tabindex="-1" role="dialog" aria-labelledby="editTaskModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editTaskModalLabel">Редагувати задачу</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="editTaskForm">
                        <div class="form-group">
                            <label for="editTaskTitle">Назва задачі</label>
                            <input type="text" class="form-control" id="editTaskTitle" value="Заголовок задачі" required>
                        </div>
                        <div class="form-group">
                            <label for="editTaskDescription">Опис задачі</label>
                            <textarea class="form-control" id="editTaskDescription" rows="3">Опис задачі</textarea>
                        </div>
                        <div class="form-group">
                            <label for="editTaskStatus">Статус задачі</label>
                            <select class="form-control" id="editTaskStatus">
                                <option value="0">В процесі</option>
                                <option value="1">Виконано</option>
                            </select>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрити</button>
                    <button type="submit" class="btn btn-primary" form="editTaskForm">Зберегти зміни</button>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            loadTasks();
        });
    </script>
@endsection