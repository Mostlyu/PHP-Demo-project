<?php

    function loadTodos(): array {
        if (!file_exists('todos.json')) {
            return [];
        }
        $contents = file_get_contents('todos.json');
        $todos = json_decode($contents, true);
        return is_array($todos) ? $todos : [];
    }

    function saveTodos(array $todos) {
        file_put_contents('todos.json', json_encode($todos, JSON_PRETTY_PRINT));
    }

    function statusToString($isOpen) {
        if ($isOpen) {
            return 'open';
        }
        return 'complete';
    }

    function addTodo($title, $datum, $description, $isOpen = true) {
    $todos = loadTodos();

    $highest = 0;
    foreach ($todos as $todo) {
        if ($todo['index'] > $highest) {
            $highest = $todo['index'];
        }
    }
    $newIndex = $highest + 1;

    $todos[] = [
        'index'       => $newIndex,
        'title'       => $title,
        'datum'       => $datum,
        'description' => $description,
        'status'      => statusToString($isOpen),
    ];

    saveTodos($todos);
}

    function deleteTodo(int $index): bool {
        $todos = loadTodos();
        $arr = [];
        foreach ($todos as $todo) {
            if ($todo['index'] != $index) {
                $arr[] = $todo;
            }
        }

        saveTodos($arr);

    }

    function filterTodos($isOpen) {
        $todos = loadTodos();
        $filter = [];
        $status = statusToString($isOpen);

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

?>