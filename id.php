<?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    include 'aufgaben.php';
    include 'handler.php';
    include 'header.php';

    $errors = [];

    if (isset($_POST['action']) && $_POST['action'] === 'delete') {
        handleDeleteTodo();
    }

    $statusFilter = null;
    if (isset($_GET['filter'])) {
        $statusFilter = $_GET['filter'];
    }
    $todos = filterTodos($statusFilter);

    if (isset($_GET['due_today'])) {
         $todos = dueTodayTodos();
    }

    if (isset($_POST['action']) && $_POST['action'] === 'toggle_status') {
        handleToggleStatus();
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['action'] === 'add') {
        handleCreateTodo();
        header("Location: id.php");
        exit;
    }

       if (isset($_POST['action']) && $_POST['action'] === 'edit') {
        foreach ($todos as $todo) {
            if ($todo->id == $_POST['id']) {
                $editingTodo = $todo;
            }
        }
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

    <h3>Write your ToDos </h3>

    <?php if (!empty($errors)): ?>
        <ul class="errors">
            <?php foreach ($errors as $error): ?>
                <li><?= htmlspecialchars($error) ?></li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>

    <div class="todo-form">
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
        <input type="hidden" name="action" value="add">
        <h4>Title</h4>
        <input name="title" value="<?= htmlspecialchars($_POST['title'] ?? '') ?>" placeholder="Title of your ToDo?" required>

        <h4>Due Date</h4>
        <input type="datetime-local" name="due_date" value="<?= htmlspecialchars($_POST['due_date'] ?? '') ?>" placeholder="The due date of your ToDo?" required>

        <h4>Description</h4>
        <textarea name="description" value="<?= htmlspecialchars($_POST['description'] ?? '') ?>" class="description" placeholder="Description of your ToDo?" required></textarea>

        <button type="submit" class="submit-button">Add ToDo</button>
    </form>
    </div>


    <h2>My TODOs</h2>

    <form method="get" action="">
        <div class="action-filters">
                    <input type="hidden" name="filter" value="complete">
                    <button type="submit">Show Complete</button>
            </form>
            <form method="get" action="">
                        <input type="hidden" name="filter" value="open">
                        <button type="submit">Show Open</button>
            </form>
             <form method="get" action="">
                        <input type="hidden" name="due_today" value="1">
                        <button type="submit">Due Today</button>
            </form>
            <form method="get" action="">
                        <input type="hidden" name="filter" value="all">
                        <button type="submit">Show All</button>
            </form>
        </div>
    </form>

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
            <td><?= htmlspecialchars($todo->id) ?></td>
            <td><?= htmlspecialchars($todo->title) ?></td>
            <td><?= htmlspecialchars($todo->description) ?></td>
            <td><?= htmlspecialchars(str_replace('T', ' ', $todo->due_date)) ?></td>
            <td><?= htmlspecialchars($todo->created_at) ?></td>
            <td><?= htmlspecialchars($todo->status->value) ?></td>
            <td>
                 <form method="post" action="">
                    <input type="hidden" name="action" value="edit">
                    <input type="hidden" name="id" value="<?= $todo->id ?>">
                    <a href="edit.php?id=<?= $todo->id ?>">
                        <button type="button">Edit</button>
                    </a>
                </form>
                <form method="post" action="">
                    <input type="hidden" name="action" value="delete">
                    <input type="hidden" name="id" value="<?= $todo->id ?>">
                    <button type="submit">Delete</button>
                </form>
                <form method="post" action="">
                    <input type="hidden" name="action" value="toggle_status">
                    <input type="hidden" name="id" value="<?= $todo->id ?>">
                    <input type="hidden" name="current_status" value="<?= $todo->status->value ?>">
                    <button type="submit"><?= $todo->status === ToDoItemStatus::OPEN ? 'Mark Complete' : 'Mark Open' ?></button>
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