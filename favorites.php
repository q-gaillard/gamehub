<?php
session_start();
include 'create_database.php';

// récupération des jeux depuis la base de données
$sql = "SELECT * FROM games";
$stmt = $pdo->query($sql);
$games = $stmt->fetchAll();

// récupération des comptes
$sql = "SELECT * FROM users";
$stmt = $pdo->query($sql);
$users = $stmt->fetchAll();

?>

<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>GameHub - Mes Jeux Favoris</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    </head>
    <body class="bg-dark text-light">
        <section>
                <h2 class="mb-4">mes Jeux favoris</h2>

                <div class="row g-4">

                    <?php foreach ($games as $game) : ?>
                        <div class="col-md-6 col-lg-3">
                            <div class="card h-100 shadow-sm">
                                <img src="images/<?php echo $game['image']; ?>" class="card-img-top" alt="Image du jeu <?php echo $game['title']; ?>" width="25%"; height="25%">
                                <div class="card-body">
                                    <h5 class="card-title"><?php echo $game['title']; ?></h5>
                                    <p class="card-text">
                                        <?php echo $game['description']; ?>
                                    </p>
                                </div>
                                <div class="card-footer">
                                    <small class="text-muted">Genre : <?php echo $game['genre']; ?></small>
                                </div>
                                <div class="card-footer">
                                    <?php
                                    // trouver le nom de l'utilisateur qui a proposé le jeu
                                    $user_id = $game['user_id'];
                                    $user_name = "Inconnu";
                                    foreach ($users as $user) {
                                        if ($user['id'] == $user_id) {
                                            $user_name = $user['login'];
                                            break;
                                        }
                                    }
                                    ?>
                                    <small class="text-muted">proposition de <?php echo $user_name; ?></small>
                                </div>
                            </div>
                        </div>

                    <?php endforeach; ?>

                </div>
            </section>
        </main>

        <footer class="bg-black text-center py-3 border-top border-secondary">
            <p class="mb-0">GameHub - Projet fil rouge BTS SIO SLAM</p>
        </footer>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    </body>
</html>