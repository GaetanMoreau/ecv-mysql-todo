<?php

require_once('./components/connect.php');

$nameIsEmpty = true;

if (isset($_POST['submit']) && !empty($_POST['name'])) {
    $sql = "INSERT INTO todo (name, content) VALUES (?, ?)";
    $stmt = $db->prepare($sql);

    $stmt->bindValue(1, $_POST['name']);
    $stmt->bindValue(2, $_POST['content']);

    $stmt->execute();

    header("location:index.php");
} elseif (isset($_POST['submit']) && empty($_POST['name'])){
    $nameIsEmpty = false;
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Création d'une tâche - ECV - TODO LIST</title>
    <link rel="stylesheet" href="assets/styles/reset.css">
    <link rel="stylesheet" href="assets/styles/master.css">
</head>

<body>
    <section>
        <div class="container">
            <h1 class="main__title">ECV TODO LIST</h1>
            <div class="prelist">
                <p class="prelist__tasks">Ajout d'une nouvelle tâche</p>
                <a href="index.php"><button class="prelist__btn">Annuler</button></a>
            </div>
            <?php if (!$nameIsEmpty) : ?>
                <?php require_once "./components/alert.php" ?>
            <?php endif ?>
            <div class="todolist">
                <form method="POST" class="create__form">
                    <label for="name">Name
                        <input type="text" id="name" name="name"></label>

                    <label for="content">Content
                        <input type="text" id="content" name="content"></label>

                    <input type="submit" value="Envoyer" name="submit" class="task__btn">
                </form>
            </div>
        </div>
    </section>
</body>

</html>