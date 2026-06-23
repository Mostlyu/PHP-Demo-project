<?php
    require_once 'JsonDataStore.php';
    require_once 'aufgaben.php';
    require_once 'ToDoItem.php';


    function handleDeleteTodo(): void {
        $id = (int) ($_POST['id'] ?? 0);
        deleteTodo($id);
        header('Location: id.php');
        exit;
        }

    function handleCreateTodo(): void {
        $title = trim($_POST['title'] ?? '');
        $due_date = $_POST['due_date'] ?? '';
        $description = trim($_POST['description'] ?? '');
        $errors = [];

        if ($title === '') {
            $errors[] = 'Title darf nicht leer sein.';
        }
        if ($description === '') {
            $errors[] = 'Beschreibung darf nicht leer sein.';
        }
        if (empty($errors)) {
            addTodo($title, $due_date, $description);
            ;
        }
    }

    function handleToggleStatus(): void {
        $newStatus = ($_POST['current_status'] === 'open') ? false : true;
        setStatus((int) $_POST['id'], $newStatus);
        header('Location: id.php');
        exit;
    }
