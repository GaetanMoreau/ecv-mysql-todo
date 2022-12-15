<?php

require_once('./components/connect.php');

if(isset($_GET['page']) && !empty($_GET['page'])){
    $currentPage = (int) strip_tags($_GET['page']);
}else{
    $currentPage = 1;
}

$todoCountStmt = $db->prepare('SELECT COUNT(*) FROM todo');
$todoCountStmt->execute();
$count = $todoCountStmt->fetchColumn();

$parPage = 10;
$pages = ceil($count / $parPage);
$premier = ($currentPage * $parPage) - $parPage;

$sql = 'SELECT * FROM todo ORDER BY `id` DESC LIMIT :premier, :parpage;';
$todosStmt = $db->prepare($sql);
$todosStmt->bindValue(':premier', $premier, PDO::PARAM_INT);
$todosStmt->bindValue(':parpage', $parPage, PDO::PARAM_INT);

$todosStmt->execute();
$todos = $todosStmt->fetchAll(PDO::FETCH_ASSOC);

if (isset($_GET['search'])) {
    $search = htmlspecialchars($_GET['search']);
    $sql = "SELECT * FROM todo WHERE name LIKE :search";
    $searchStmt = $db->prepare($sql);
    $searchStmt->execute([
        'search'=>'%'.$search.'%'
    ]);
    $todos = $searchStmt->fetchAll();
}

?>

<!DOCTYPE html>
<html lang="fr">

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
                <div class="prelist__tass-container">
                    <p class="prelist__tasks"><?= $count ?> <?= ($count > 1) ? "tâches" : "tâche"; ?></p>
                    <form class="search__form">
                        <input type="text" name="search" placeholder="Rechercher">
                        <input type="submit" value="Rechercher" class="task__btn">
                    </form>
                </div>
                <div class="btn__container">
                    <a href="index.php" class="prelist__btn">Actualiser</a>
                    <a href="create.php" class="prelist__btn">Nouvelle tâche</a>
                </div>
            </div>
            <div class="todolist">
                <?php if ($todos) : ?>
                    <?php foreach ($todos as $task) : ?>
                        <div class="task">
                            <div class="task__title">
                                <h2 class="primary__title"><?= $task['name'] ?></h2>
                                <span class="task__tag <?= ($task['done'] == 0) ? "" : "done"; ?>"><?= ($task['done'] == 0) ? "En cours" : "Terminé"; ?></span>
                            </div>
                            <div>
                                <p class="primary__content"><?= $task['content'] ?></p>
                                <div class="task__btns">
                                    <a href="update.php?id=<?= $task['id'] ?>&name=<?= $task['name'] ?>&content=<?= $task['content'] ?>" class="task__btn">Modifier</a>
                                    <a href="delete.php?id=<?= $task['id'] ?>" class="task__btn">Supprimer</a>
                                    <a href="update_status.php?id=<?= $task['id']?>&done=<?= $task['done'] ?>" class="task__btn"><?= ($task['done'] == 0) ? "Terminé" : "Reprendre"; ?></a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else : ?>
                    <p class="primary__title">Votre todo-list est vide.</p>
                <?php endif ?>
            </div>
            <?php if ($count >= 1) : ?>
                <div class="delete-all btn__container">
                    <a href="deleteAll.php" class="delete__all-btn">Tout supprimer</a>
                </div>
            <?php endif ?>
            <?php if ($todos) : ?>
                <ul class="pagination">
                    <li class="<?= ($currentPage == 1) ? "disabled" : "" ?>">
                        <a href="./?page=<?= $currentPage - 1 ?>">Précédente</a>
                    </li>
                    <?php for($page = 1; $page <= $pages; $page++): ?>
                        <li class=" <?= ($currentPage == $page) ? "active" : "" ?>">
                            <a href="./?page=<?= $page ?>"><?= $page ?></a>
                        </li>
                    <?php endfor ?>
                    <li class="<?= ($currentPage == $pages) ? "disabled" : "" ?>">
                        <a href="./?page=<?= $currentPage + 1 ?>">Suivante</a>
                    </li>
                </ul>
            <?php endif ?>
        </div>
    </section>
</body>

</html>