<?php

    include 'ToDoItem.php';
    include 'ToDoItemStatus.php';
    require_once 'JsonDataStore.php';

    function addTodo(
        string $title,
        string $dueDate,
        string $description,

        ToDoItemStatus $status = ToDoItemStatus::OPEN) {

        $todos = JsonDataStore::loadTodos();

        $newTodo = new ToDoItem(
            $title,
            $dueDate,
            $description,
            $status
        );

        $newTodo->id = JsonDataStore::getNextId();

        $todos[] = $newTodo;

        JsonDataStore::saveTodos($todos);
    }

    function deleteTodo(int $id) {
        $todos = JsonDataStore::loadTodos();
        $arr = [];
        foreach ($todos as $todo) {
            if ($todo-> id != $id) {
                $arr[] = $todo;
            }
        }

        JsonDataStore::saveTodos($arr);

    }

    /**
     * Filters todos by status.
     * @return array<ToDoItem> of todos filtered by status. If status is empty, returns all todos.
     */
    function filterTodos(string|null $statusFilter): array {
        $allTodoItems = JsonDataStore::loadTodos();
        $filteredTodoItems = [];

        // what if filter is empty?
        if (empty($statusFilter) || $statusFilter === 'all') {
            return $allTodoItems;
        }

        foreach ($allTodoItems as $todo) {
            if ($todo->status->value == $statusFilter) {
                $filteredTodoItems[] = $todo;
            }
        }
        return $filteredTodoItems;
    }

    function editTodo(string $title, int $id, string $due_date, string $description) {
        $todos = JsonDataStore::loadTodos();

        foreach ($todos as $key => $todo) {
            if ($todo->id == $id) {
                $todos[$key]->title = $title;
                $todos[$key]->due_date = $due_date;
                $todos[$key]->description = $description;
                JsonDataStore::saveTodos($todos);
                return;
            }
        }
    }

    function setStatus(int $id, bool $isOpen) {
        $todos = JsonDataStore::loadTodos();

        try
        {

            foreach ($todos as $todo) {
                if ($todo->id == $id) {
                    $todo->status = $isOpen ? ToDoItemStatus::OPEN : ToDoItemStatus::COMPLETE;
                    JsonDataStore::saveTodos($todos);
                    return;
                }
            }
        } catch (Exception $e) {
            error_log($e->getMessage());
            return;
        }

    }

    function dueTodayTodos(): array {
        $allTodoItems = JsonDataStore::loadTodos();
        $dueTodayTodoItems = [];
        // $now = new DateTime();

        foreach ($allTodoItems as $due_today) {
            if (date('Y-m-d') == substr($due_today->due_date, 0, 10)) {
                $dueTodayTodoItems[] = $due_today;
            }
        }
        return $dueTodayTodoItems;
    }

    /**
     * @param string $input The input string to validate as a date.
     * @return true if the input is a valid date in the format YYYY-MM-DD, false otherwise.
     */
    // function check_date(string $input): bool {
    //     $date = DateTime::createFromFormat('Y-m-d', $input);
    //     return $date && $date->format('Y-m-d') === $input;
    // }

?>