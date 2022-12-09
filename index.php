<?php

try {
    $db = new PDO('mysql:host=localhost;dbname=todos;charset=utf8', 'root', 'root');
} catch (Exception $e) {
    die('Erreur : ' . $e->getMessage());
}

$sql = 'SELECT * FROM todo';
$todosStmt = $db->prepare($sql);
$todosStmt->execute();
$todos = $todosStmt->fetchAll();

$sql = 'SELECT COUNT(*) FROM todo';
$todoCountStmt = $db->prepare($sql);
$todoCountStmt->execute();
$todoCount = $todosStmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ECV - TODO LIST</title>
    <link rel="stylesheet" href="assets/styles/reset.css">
    <link rel="stylesheet" href="assets/styles/master.css">
</head>

<body>
    <section>
        <div class="container">
            <h1 class="main__title">ECV TODO LIST</h1>
            <div class="prelist">
                <p class="prelist__tasks"><?= $todoCount ?> tâches</p>
                <button class="prelist__btn">Nouvelle tâche</button>
            </div>
            <div class="todolist">
                <?php if ($condition) : ?>
                    <?php foreach ($todos as $task) : ?>
                        <div class="task">
                            <div class="task__title">
                                <h2 class="primary__title"><?= $task['title'] ?></h2>
                                <span><?= ($task['done'] === 1) ? "En cours" : "Terminé"; ?></span>
                            </div>
                            <div>
                                <p class="primary__content"><?= $task['content'] ?></p>
                                <div class="task__btns">
                                    <a href="update.html"><button class="task__btn">Modifier</button></a>
                                    <button class="task__btn">Supprimer</button>
                                    <button class="task__btn">Terminer</button>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else : ?>
                    <p class="primary__title">Votre todo list est vide.</p>
                <?php endif ?>
            </div>
        </div>
    </section>
</body>

</html>