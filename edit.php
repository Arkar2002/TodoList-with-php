<?php

require_once "db_connection.php";

date_default_timezone_set("Asia/Yangon");

$db = new DB();

$task = $db->show($_GET['id']);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit</title>
</head>

<body>

    <form action="update.php" method="POST">
        <div class="form-group">
            <input type="text" name="id" value="<?= $_GET['id']; ?>" hidden>
            <label for="task">Task Name</label>
            <input type="text" name="taskName" class="form-control" value="<?= $task->name; ?>">
            <input type="text" name="updatedTime" value="<?= date("Y-m-d H:i:s", time()); ?>" hidden>
        </div>
        <button>Update</button>
    </form>

</body>

</html>