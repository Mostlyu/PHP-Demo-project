<?php
    const TODO_FILE = 'todos.json';

    function loadTodos(): array {
        if (!file_exists(TODO_FILE)) {
            return [];
        }
        $contents = file_get_contents(TODO_FILE);
        if ($contents === false) {
            return [];
        }
        $todos = json_decode($contents, true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            error_log("JSON decode error: " . json_last_error_msg());
            return [];
        }
        return is_array($todos) ? $todos : [];
    }

    function saveTodos(array $todos): bool{
        if(file_put_contents(TODO_FILE, json_encode($todos, JSON_PRETTY_PRINT), LOCK_EX) === false) {
            error_log('Failed to save todos');
            return false;
        }
        return true;
    }

    function statusToString($isOpen) {
        if ($isOpen) {
            return 'open';
        }
        return 'complete';
    }

    function addTodo($title, $dueDate,$description, $isOpen = true) {
    $todos = loadTodos();

    $highest = 0;
    foreach ($todos as $todo) {
        if ($todo['index'] > $highest) {
            $highest = $todo['index'];
        }
    }
    $createdAt = date('Y-m-d H:i:s');
    $newIndex = $highest + 1;

    $todos[] = [
        'index'       => $newIndex,
        'created_at'  => $createdAt,
        'title'       => $title,
        'due_date'       => $dueDate,
        'description' => $description,
        'status'      => statusToString($isOpen),
    ];

    saveTodos($todos);

    }

    function deleteTodo(int $index) {
        $todos = loadTodos();
        $arr = [];
        foreach ($todos as $todo) {
            if ($todo['index'] != $index) {
                $arr[] = $todo;
            }
        }

        saveTodos($arr);

    }

    function filterTodos(string $status) {
        $todos = loadTodos();
        $filter = [];

        foreach ($todos as $todo) {
            if ($todo['status'] == $status) {
                $filter[] = $todo;
            }
        }
        return $filter;
    }

    function setStatus($index, $isOpen) {
        $todos = loadTodos();

        foreach ($todos as $key => $todo) {
            if ($todo['index'] == $index) {
                $todos[$key]['status'] = statusToString($isOpen);
                saveTodos($todos);
                return;
            }
        }
    }

    function check_date($input) {
        $date = DateTime::createFromFormat('Y-m-d', $input);
        return $date && $date->format('Y-m-d') === $input;
    }

?>