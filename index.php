<?php

session_start();
require_once("db_connection.php");

$db = new DB();

$tasks = $db->index();


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>To Do List</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: inherit;
        }

        body {
            font-family: sans-serif;
            height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            background-color: #333;
            box-sizing: border-box;
        }

        .container {
            max-width: 400px;
            width: 100%;
            background-color: #f4f4f4;
            border-radius: 3px;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.2);
            padding: 20px;
        }

        form>* {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 10px;
        }

        input[type=text] {
            width: 100%;
            padding: 8px;
            background-color: #f4f4f4;
            border: none;
            border-bottom: 3px solid yellow;
            border-radius: 3px;
        }

        input:focus {
            outline: 0;
        }

        button,
        .clear {
            color: #fff;
            padding: 10px 20px;
            background-color: steelblue;
            border: none;
            border-radius: 3px;
            cursor: pointer;
            text-decoration: none;
        }

        .clearContainer {
            display: flex;
            justify-content: end;
            margin-bottom: 20px;
        }

        ul {
            list-style: none;
        }

        ul li {
            display: block;
            padding: 10px;
            padding-left: 30px;
            background-color: #bbb;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: relative;
            margin-bottom: 3px;
        }

        .check {
            width: 15px;
            height: 15px;
            border-radius: 50%;
            background-color: #f4f4f4;
            position: absolute;
            left: 5px;
            top: 50%;
            transform: translate(0, -50%);
        }

        .check.checked {
            background-color: forestgreen;
        }

        input[type=checkbox]:checked+span {
            font-style: italic;
            text-decoration: line-through;
        }

        ul li .time {
            font-size: 14px;
            display: inline-block;
            position: absolute;
            left: 10px;
            top: -2px;
        }

        ul li:hover {
            background-color: #ddd;
        }

        .change {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 20px;
        }

        .change a {
            color: #000;
            text-decoration: none;
        }

        .change .edit {
            color: #fff;
            display: inline-block;
            padding: 5px 8px;
            background-color: steelblue;
            border-radius: 3px;
        }

        .change .edit:hover {
            opacity: 0.9;
        }

        .change .delete {
            font-size: 25px;
            color: red;
        }

        .change .delete:hover {
            opacity: 0.9;
        }

        .red {
            color: red;
        }
    </style>
</head>

<body>

    <?php
    if (count($_SESSION) > 0) $errorName = $_SESSION["errorName"];
    else $errorName = "";
    ?>

    <div class="container">
        <form action="create.php" method="POST">
            <h1>Todo List</h1>
            <div class="form-group">
                <label for="name">Your Task</label>
                <input type="text" name="taskName" id="name" placeholder="Add Task">
                <small class="red"><?= $errorName ?></small>
            </div>
            <button name="addBtn">Add</button>
        </form>

        <div class="clearContainer">
            <?php if ($tasks) : ?>
                <a href="deleteAll.php" class="clear">Clear All</a>
            <?php endif;  ?>
        </div>

        <ul>
            <?php if ($tasks) : ?>
                <?php foreach ($tasks as $task) : ?>
                    <li>
                        <a class="check <?php if ($task->done) echo "checked"; ?>" href="done.php?done=1&id=<?= $task->id; ?>"></a>
                        <input type="checkbox" <?php if ($task->done) echo "checked"; ?> hidden>
                        <span><?= $task->name ?></span>

                        <span class="change">
                            <?php if (!$task->done) : ?>
                                <a href="edit.php?id=<?= $task->id; ?>" class="edit">Edit</a>
                            <?php endif; ?>
                            <a href="delete.php?id=<?= $task->id; ?>" class="delete">&times;</a>
                        </span>
                        <span class="time">
                            <?php
                            $createdTime = strtotime($task->created_at);
                            $updatedTime = strtotime($task->updated_at);
                            if ($createdTime === $updatedTime) echo date("h:i A", $createdTime);
                            else echo "Updated " . date("h:i A", $updatedTime);
                            ?>
                        </span>
                    </li>
                <?php endforeach; ?>
            <?php endif; ?>

        </ul>
    </div>

</body>

</html>