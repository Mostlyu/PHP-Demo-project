<?php
    require_once 'JsonDataStore.php';
    require_once 'aufgaben.php';
    require_once 'ToDoItem.php';
    require_once 'index.php';


    function handleDeleteTodo(): void {
        $index = (int) ($_POST['index'] ?? 0);
        deleteTodo($index);
        header('Location: index.php');
        exit;
        }

    function handleCreateTodo(): void {
        $title = trim($_POST['title'] ?? '');
        $due_date = $_POST['due_date'] ?? '';
        $description = trim($_POST['description'] ?? '');

        if ($title === '') {
            $errors[] = 'Title darf nicht leer sein.';
        }
        if ($description === '') {
            $errors[] = 'Beschreibung darf nicht leer sein.';
        }
        if (empty($errors)) {
            addTodo($title, $due_date, $description);
            //header('Location: index.php');
            exit;
        }
    }

    function handleToggleStatus(): void {
        $newStatus = ($_POST['current_status'] === 'open') ? false : true;
        setStatus((int) $_POST['index'], $newStatus);
        header('Location: index.php');
        exit;
    }
