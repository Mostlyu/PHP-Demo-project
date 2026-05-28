<?php
    include 'aufgabe.php';
    include 'header.php';
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>TODO App</title>
    </head>
        <body>
            <h1>TODO App</h1>
            <table>
                <tr>
                    <th>Index</th>
                    <th>Title</th>
                    <th>Datum</th>
                    <th>Description</th>
                    <th>Status</th>
                </tr>
                <?php foreach (loadTodos() as $todo): ?>
                    <tr>
                        <td><?php echo $todo['index']; ?></td>
                        <td><?php echo $todo['title']; ?></td>
                        <td><?php echo $todo['datum']; ?></td>
                        <td><?php echo $todo['description']; ?></td>
                        <td><?php echo $todo['status']; ?></td>
                    </tr>
                <?php endforeach; ?>
            </table>
            <img src="images/todo-1.png" alt="TODO App Image">
        </body>
</html>

<?php
    include 'footer.php';
?>