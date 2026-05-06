<?php
session_start();
include 'create_database.php';

// récupération des comptes
$sql = "SELECT * FROM users";
$stmt = $pdo->query($sql);
$users = $stmt->fetchAll();

// récupération des favoris
$sql = "SELECT * FROM favoris";
$stmt = $pdo->query($sql);
$favoris = $stmt->fetchAll();

// récupération des jeux mis en favoris
$sql = "SELECT games.* 
        FROM games
        JOIN favoris ON games.id = favoris.idGame
        WHERE favoris.idUser = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$_SESSION['user_id']]);
$games = $stmt->fetchAll();

if (isset($_SESSION['user_id'])) {
    $sql = "SELECT idGame FROM favoris WHERE idUser = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$_SESSION['user_id']]);
    
    // on récupère juste les IDs des jeux favoris
    $favorites = $stmt->fetchAll(PDO::FETCH_COLUMN);
}

?>

<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>GameHub - Mes Jeux Favoris</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    </head>
    <body class="bg-dark text-light">

    <nav class="navbar navbar-expand-lg navbar-dark bg-black border-bottom border-secondary">
        <div class="container">
            <a class="navbar-brand fw-bold" href="index.php">GameHub</a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#menuNavbar">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="menuNavbar">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="index.html">Accueil</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="register.html">Inscription</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="login.html">Connexion</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <header class="py-5 bg-secondary-subtle text-dark">
        <div class="container text-center">
            <h1 class="display-4 fw-bold">Bienvenue sur GameHub</h1>
            <p class="lead mt-3">
                Découvrez une sélection de jeux vidéo et créez votre compte pour accéder à votre futur espace personnel.
            </p>
        </div>
    </header>

        <main class="container py-5">
            <section>
                    <h2 class="mb-4">mes Jeux favoris</h2>

                    <div class="row g-4">

                        <?php $nbGames = 0 ?>
                        <?php foreach ($games as $game) : ?>
                            <?php $nbGames = $nbGames + 1 ?>
                            <div class="col-md-6 col-lg-3">
                                <div class="card h-100 shadow-sm">
                                    <img src="images/<?php echo $game['image']; ?>" class="card-img-top" alt="Image du jeu <?php echo $game['title']; ?>">
                                    <div class="card-body">
                                        <h5 class="card-title"><?php echo $game['title']; ?></h5>
                                        <br/>
                                        <?php
                                            if (in_array($game['id'], $favorites))
                                            {
                                            ?>
                                                <form method="POST" action="enlever_favoris.php">
                                                    <input type="hidden" name="game_id" value="<?php echo $game['id']; ?>">
                                                    <button type="submit" class="btn btn-primary">je n'aime plus</button>
                                                </form>
                                            <?php } ?>
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
                                        foreach ($users as $user)
                                        {
                                            if ($user['id'] == $user_id)
                                            {
                                                $user_name = $user['login'];
                                                break;
                                            }
                                        }
                                        ?>
                                        <small class="text-muted">proposition de <?php echo $user_name; ?></small>
                                    </div>
                                </div>
                            </div>

                        <?php
                        endforeach;
                        ?>

                    </div>
                </section>

        <?php
        if ($nbGames == 0)
        {
        ?>
            <br/><br/>
            <section class="mb-5">
                <p>
                    tu n'as mis aucun jeu en favoris...   :(
                </p>
            <section class="mb-5">
        <?php
        }
        ?>
        </main>

        <footer class="bg-black text-center py-3 border-top border-secondary">
            <p class="mb-0">GameHub - Projet fil rouge BTS SIO SLAM</p>
        </footer>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    </body>
</html>