<?php

    include 'ToDoItem.php';
    include 'ToDoItemStatus.php';
    require_once 'JsonDataStore.php';


    // const TODO_FILE = 'todos.json';

    // function loadTodos(): array {
    //     if (!file_exists(TODO_FILE)) {
    //         return [];
    //     }
    //     $contents = file_get_contents(TODO_FILE);
    //     if ($contents === false) {
    //         return [];
    //     }

    //     $rawToDos = json_decode($contents, true);
    //     foreach ($rawToDos as $rawToDo) {
    //         $todos[] = ToDoItem::fromArray($rawToDo);
    //     }

    //     if (json_last_error() !== JSON_ERROR_NONE) {
    //         error_log("JSON decode error: " . json_last_error_msg());
    //         return [];
    //     }
    //     return $todos ?? [];
    // }

    // function saveTodos(array $todos): bool{
    //     if(file_put_contents(TODO_FILE, json_encode($todos, JSON_PRETTY_PRINT), LOCK_EX) === false) {
    //         error_log('Failed to save todos');
    //         return false;
    //     }
    //     return true;
    // }


    function statusToString(bool $isOpen): string {
        if ($isOpen) {
            return 'open';
        }
        return 'complete';
    }

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

        echo "item created";

        $todos[] = $newTodo;
        // var_dump($newTodo);
        JsonDataStore::saveTodos($todos);
    }

    function deleteTodo(int $index) {
        $todos = JsonDataStore::loadTodos();
        $arr = [];
        foreach ($todos as $todo) {
            if ($todo-> index != $index) {
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

    function setStatus(int $index, bool $isOpen) {
        $todos = JsonDataStore::loadTodos();

        try
        {
            // foreach ($todos as $key => $todo) {
            //     if ($todo['index'] == $index) {



            //         $todos[$key]['status'] = statusToString($isOpen);
            //         JsonDataStore::saveTodos($todos);
            //         return;
            //     }
            // }
            foreach ($todos as $todo) {
                if ($todo->index == $index) {
                    $todo->setStatus($isOpen ? ToDoItemStatus::OPEN : ToDoItemStatus::COMPLETE);
                    JsonDataStore::saveTodos($todos);
                    return;
    }
}
        } catch (Exception $e) {
            error_log($e->getMessage());
            return;
        }

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