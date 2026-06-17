<?php

// save & load todos from json file
class JsonDataStore {

    public const TODO_FILE = 'todos.json';

    public static function loadTodos(): array {
        if (!file_exists(self::TODO_FILE)) {
            return [];
        }
        $contents = file_get_contents(self::TODO_FILE);
        if ($contents === false) {
            return [];
        }

        $rawToDos = json_decode($contents, true);
        if (is_array($rawToDos)) {
            foreach ($rawToDos as $rawToDo) {
                $todos[] = ToDoItem::fromArray($rawToDo);
            }
        }

        if (json_last_error() !== JSON_ERROR_NONE) {
            error_log("JSON decode error: " . json_last_error_msg());
            return [];
        }
        return $todos ?? [];
    }

    public static function saveTodos(array $todos): bool{

        var_dump($todos);

        echo "saving";

        $rawToDos = [];
        foreach ($todos as $todo) {
             $rawToDos[] = $todo->toArray();
         }

        if(file_put_contents(self::TODO_FILE, json_encode($rawToDos, JSON_PRETTY_PRINT), LOCK_EX) === false) {
            error_log('Failed to save todos');
            return false;
        }
        return true;
    }

    public static function getLatestIndex(): int {
        $highest = 0;

        $todos = self::loadTodos();

        foreach ($todos as $todo) {
            if ($todo->index > $highest) {
                $highest = $todo->index;
            }
        }
        return $highest;
    }

}