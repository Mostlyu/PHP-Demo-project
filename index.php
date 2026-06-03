<?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    include 'aufgaben.php';

    include 'header.php';
    if (isset($_POST['title']) && isset($_POST['due_date']) && isset($_POST['description'])) {
        addTodo($_POST['title'], $_POST['due_date'], $_POST['description']);
        header("Location: index.php");
        exit;
    }
    if (isset($_POST['action']) && $_POST['action'] === 'delete') {
        deleteTodo((int) $_POST['index']);
        header('Location: index.php');
        exit;
    }

    if (isset($_POST['filter'])) {
        $todos = filterTodos($_POST['filter']);
    } else {
        $todos = loadTodos();
    }

    if (isset($_POST['action']) && $_POST['action'] === 'toggle_status') {
        $newStatus = ($_POST['current_status'] === 'open') ? false : true;
        setstatus((int) $_POST['index'], $newStatus);
        header('Location: index.php');
        exit;
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>TODO App</title>
    <link rel="stylesheet" href="style/style.css">
</head>
<body>

    <h3>My ToDos</h3>

    <form method="post" action="">
        <h4>Title</h4>
        <input name="title" placeholder="Title of your ToDo?" required>

        <h4>Due Date</h4>
        <input name="due_date" placeholder="The due date of your ToDo?" required>

        <h4>Description</h4>
        <textarea name="description" class="description" placeholder="Description of your ToDo?" required></textarea>

        <button type="submit">Add ToDo</button>
    </form>

    <h2>Current TODOs</h2>
    <?php $todos = loadTodos(); ?>

<table>
    <thead>
        <tr>
            <th>#</th>
            <th>Title</th>
            <th>Description</th>
            <th>Due Date</th>
            <th>Created</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($todos as $todo): ?>
        <tr>
            <td><?= htmlspecialchars($todo['index']) ?></td>
            <td><?= htmlspecialchars($todo['title']) ?></td>
            <td><?= htmlspecialchars($todo['description']) ?></td>
            <td><?= htmlspecialchars($todo['due_date']) ?></td>
            <td><?= htmlspecialchars($todo['created_at']) ?></td>
            <td><?= htmlspecialchars($todo['status']) ?></td>
            <td>
                <form method="post" action="">
                    <input type="hidden" name="action" value="delete">
                    <input type="hidden" name="index" value="<?= $todo['index'] ?>">
                    <button type="submit">Delete</button>
                </form>
                <form method="post" action="">
                    <input type="hidden" name="action" value="toggle_status">
                    <input type="hidden" name="index" value="<?= $todo['index'] ?>">
                    <input type="hidden" name="current_status" value="<?= $todo['status'] ?>">
                    <button type="submit"><?= $todo['status'] === 'open' ? 'Mark Complete' : 'Mark Open' ?></button>
                </form>
                <form method="post" action="">
                    <input type="hidden" name="filter" value="<?= $todo['status'] ?>">
                    <button type="submit">Filter <?= $todo['status'] ?></button>
                </form>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

</body>
</html>

<?php
    include 'footer.php';
?>