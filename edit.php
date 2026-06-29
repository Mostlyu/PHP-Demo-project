<?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    include 'JsonDataStore.php';
    include 'handler.php';
    include 'header.php';

    $id = (int) ($_GET['id'] ?? 0);
    $todos = JsonDataStore::loadTodos();

    foreach ($todos as $todo) {
        if ($todo->id == $id ) {
            $editingTodo = $todo;
            break;
        }
    }

    if (isset($_POST['action']) && $_POST['action'] === 'save_edit') {
    handleEditTodo();
    header('Location: id.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Todos</title>
    <link rel="stylesheet" href="style/style.css">

</head>
<body>

<h3>Edit your ToDos </h3>
    <?php if (isset($editingTodo)): ?>
        <!-- edit form goes here -->
        <div class="todo-form">
            <form method="post" action="">
                <input type="hidden" name="action" value="save_edit">
                <input type="hidden" name="id" value="<?= $editingTodo->id ?>">
                <h4>Title</h4>
                <input name="title" value="<?= htmlspecialchars($editingTodo->title) ?>">
                <h4>Due Date</h4>
                <input type="datetime-local" name="due_date" value="<?= htmlspecialchars($editingTodo->due_date) ?>">
                <h4>Description</h4>
                <textarea name="description"><?= htmlspecialchars($editingTodo->description) ?></textarea>
                <button type="submit">Save</button>
            </form>
        </div>
        <?php endif; ?>
</body>
</html>

<?php
    include 'footer.php';

?>