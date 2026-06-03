<?php
    include 'aufgaben.php';

    include 'header.php';
    if (isset($_POST['title']) && isset($_POST['datum']) && isset($_POST['description'])) {
        addTodo($_POST['title'], $_POST['datum'], $_POST['description']);
    }


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>TODO App</title>
</head>
<body>

    <h3>My TODOs</h3>

    <form method="post" action="">
        <h4>Title</h4>
        <input name="title" placeholder="Title of your ToDo?" required>

        <h4>Date</h4>
        <input name="datum" placeholder="Date of your ToDo?" required>

        <h4>Description</h4>
        <input name="description" placeholder="Description of your ToDo?" required>

        <button type="submit">Add ToDo</button>
    </form>

    <h2>Current TODOs</h2>
    <?php
        $todos = loadTodos();
        foreach ($todos as $todo) {
            echo "<p>#" . $todo['index'] . " — "
                . $todo['title'] . " (" . $todo['status'] . ")"
                . "<br>" . $todo['datum']
                . "<br>" . $todo['description'] . "</p>";
        }
    ?>

</body>
</html>

<?php
    include 'footer.php';
?>