<?php

class DB
{
    protected $pdo;

    public function __construct()
    {
        try {
            $this->pdo = new PDO("mysql:dbname=todo_list;host=localhost", "root", "");
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            var_dump($e->getMessage());
        }
    }

    public function create($data)
    {
        $statement = $this->pdo->prepare("
            INSERT INTO tasks(`name`)
            VALUE(:name)
        ");

        $statement->bindParam(":name", $data["taskName"]);

        if ($statement->execute()) {
            header("Location: index.php");
        }
    }

    public function index()
    {
        $statement = $this->pdo->query("
            SELECT * FROM tasks
        ");

        if ($statement) {
            return $statement->fetchAll(PDO::FETCH_OBJ);
        }
    }

    public function update($data)
    {

        $statement = $this->pdo->prepare("
            UPDATE tasks
            SET name=:name, updated_at=:updatedTime
            WHERE id=:id
        ");

        $statement->bindParam(":id", $data["id"]);
        $statement->bindParam(":name", $data["taskName"]);
        $statement->bindParam(":updatedTime", $data["updatedTime"]);

        if ($statement->execute()) {
            header("Location: index.php");
        }
    }

    public function show($id)
    {
        $statement = $this->pdo->prepare("
            SELECT * FROM tasks WHERE id=:id
        ");

        $statement->bindParam(":id", $id);

        if ($statement->execute()) {
            return $statement->fetch(PDO::FETCH_OBJ);
        };
    }

    public function done($data)
    {

        $statement = $this->pdo->prepare("
           UPDATE tasks
           SET done=:done
           WHERE id=:id
        ");

        $statement->bindParam(":id", $data["id"]);
        $statement->bindParam(":done", $data["done"]);

        if ($statement->execute()) {
            header("Location: index.php");
        };
    }

    public function destory($id)
    {

        $statement = $this->pdo->prepare("
            DELETE FROM tasks WHERE id = :id
        ");

        $statement->bindParam(":id", $id);

        if ($statement->execute()) header("Location: index.php");
    }

    public function deleteAll()
    {
        $statement = $this->pdo->query("
            TRUNCATE TABLE tasks
        ");

        if ($statement) header("Location: index.php");
    }
}
