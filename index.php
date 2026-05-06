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

// récupération des favoris
$sql = "SELECT * FROM favoris";
$stmt = $pdo->query($sql);
$favoris = $stmt->fetchAll();

// crée une liste avec les id des jeux en favoris

$favorites = [];

if (isset($_SESSION['user_id'])) {
    $sql = "SELECT idGame FROM favoris WHERE idUser = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$_SESSION['user_id']]);
    
    // on récupère juste les IDs des jeux favoris
    $favorites = $stmt->fetchAll(PDO::FETCH_COLUMN);
}

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GameHub - Accueil</title>
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
            <div class="mt-4">
                <?php if (!isset($_SESSION['identifier'])) : ?>
                    <a href="register.html" class="btn btn-primary me-2">S'inscrire</a>
                    <a href="login.html" class="btn btn-outline-dark">Se connecter</a>
                <?php endif; ?>
                <?php if (isset($_SESSION['identifier'])) : ?>
                    <h3>Bonjour <?php echo htmlspecialchars($_SESSION['identifier']); ?></h3>
                    <a href="disconnection.php" class="btn btn-outline-dark">Se déconnecter</a>
                <?php endif; ?>
            </div>
        </div>
    </header>

    <main class="container py-5">
        <section class="mb-5">
            <h2 class="mb-3">À propos du projet</h2>
            <p>
                GameHub est un mini site web consacré aux jeux vidéo. le site permet de gérer des comptes utilisateurs,
                d'afficher les jeux depuis une base de données et d'ajouter des jeux favoris.
            </p>

            <hr class="my-4 border-secondary">
        </section>

        <section>
            <h2 class="mb-4">Jeux mis en avant</h2>

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
                                if (!in_array($game['id'], $favorites) && isset($_SESSION['identifier']))
                                {
                                ?>
                                    <form method="POST" action="add_favoris.php">
                                        <input type="hidden" name="game_id" value="<?php echo $game['id']; ?>">
                                        <button type="submit" class="btn btn-danger">ajouter en favoris</button>
                                    </form>
                                <?php
                                }
                                else if (isset($_SESSION['identifier']))
                                {
                                ?>
                                    <h6>( Jeu en favorie )</h6>
                                <?php
                                }
                                ?>
                                <br/>
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

        <?php
        if ($nbGames == 0)
        {
            if (!isset($_SESSION['identifier']))
            {
        ?>
            <section class="mb-5">
                <p>
                    il semble que n'a ajouté de jeu, pourquoi pas créer
                    un compte et ajouté le tient !
                </p>
                <a href="register.html" class="btn btn-light">inscription</a>
            <section class="mb-5">
        <?php
            }
            else
            {
        ?>
            <section class="mb-5">
                <p>
                    il semble que n'a ajouté de jeu, pourquoi ajouté le tient !
                </p>
                <a href="add_game.html" class="btn btn-light">Ajouter un jeu</a>
            <section class="mb-5">
        <?php
            }
        }
        ?>

        <br/><br/>
        <hr class="my-4 border-secondary">

        <section class="mb-5">
            <?php if (isset($_SESSION['identifier'])) : ?>
                <?php
                if ($nbGames != 0)
                {
                ?>
                    <h2 class="mb-3">Ajouter mon jeu</h2>
                    <p>
                        En tant qu'utilisateur connecté, vous pouvez ajouter vos jeux préférés.
                        Cliquez sur le bouton ci-dessous pour accéder au formulaire d'ajout de jeu.
                    </p>
                    <a href="add_game.html" class="btn btn-light">Ajouter un jeu</a>
                    <br/><br/>

                    <hr class="my-4 border-secondary">

                    <h2 class="mb-3">Mes jeux favoris</h2>
                    <p>
                        En tant qu'utilisateur connecté, vous pouvez gérer vos jeux favoris.
                        Cliquez sur le bouton ci-dessous pour accéder à votre liste de jeux favoris.
                    </p>
                    <a href="favorites.php" class="btn btn-light">Voir mes jeux favoris</a>
                <?php } ?>
                <?php endif; ?>
        </section>
    </main>

    <footer class="bg-black text-center py-3 border-top border-secondary">
        <p class="mb-0">GameHub - Projet fil rouge BTS SIO SLAM</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>