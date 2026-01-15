<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Traitement de l'inscription - Blog d'Articles v4</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <nav class="navbar navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="index.php">Mon Blog</a>
            <div class="d-flex">
                <a class="btn btn-outline-light btn-sm me-2" href="index.php">← Retour au blog</a>
                <a class="btn btn-outline-light btn-sm me-2" href="contact_form.html">📧 Contact</a>
                <a class="btn btn-outline-light btn-sm" href="article_form.html">📝 Articles</a>
            </div>
        </div>
    </nav>

    <div class="container mt-5">
        <h1>Résultat de l'inscription</h1>

        <?php
        // Initialiser les variables
        $errors = [];
        $username = '';
        $email = '';
        $password = '';
        $password_confirm = '';
        $terms = false;
        $inscription_valide = false;

        // Vérifier si le formulaire a été soumis
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Récupérer et nettoyer les données
            $username = trim($_POST['username'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $password = $_POST['password'] ?? '';
            $password_confirm = $_POST['password_confirm'] ?? '';
            $terms = isset($_POST['terms']) ? true : false;

            // =============================================
            // COUCHE 1: Vérification de l'Existence (Obligatoires)
            // =============================================

            // Champ 1: Username
            if (empty($username)) {
                $errors[] = "Le nom d'utilisateur est obligatoire";
            }

            // Champ 2: Email
            if (empty($email)) {
                $errors[] = "L'email est obligatoire";
            }

            // Champ 3: Mot de passe
            if (empty($password)) {
                $errors[] = "Le mot de passe est obligatoire";
            }

            // Champ 4: Confirmation mot de passe
            if (empty($password_confirm)) {
                $errors[] = "La confirmation du mot de passe est obligatoire";
            }

            // Champ 5: Conditions
            if (!$terms) {
                $errors[] = "Vous devez accepter les conditions d'utilisation";
            }

            // =============================================
            // COUCHE 2: Validation de Format et Contraintes
            // =============================================

            // Username: Longueur + caractères autorisés
            if (!empty($username) && (strlen($username) < 3 || strlen($username) > 20)) {
                $errors[] = "Le nom d'utilisateur doit avoir entre 3 et 20 caractères";
            }

            if (!empty($username) && !preg_match('/^[a-zA-Z0-9\-]+$/', $username)) {
                $errors[] = "Le nom d'utilisateur doit contenir seulement des lettres, chiffres et tirets";
            }

            // Email: Format valide
            if (!empty($email) && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors[] = "L'email n'est pas valide";
            }

            // Mot de passe: Longueur
            if (!empty($password) && strlen($password) < 8) {
                $errors[] = "Le mot de passe doit avoir au minimum 8 caractères";
            }

            // Confirmation: Correspondance
            if (!empty($password) && !empty($password_confirm) && $password !== $password_confirm) {
                $errors[] = "Les mots de passe ne correspondent pas";
            }

            // =============================================
            // Sécurité: Échapper toutes les données avec htmlspecialchars()
            // =============================================
            $username_safe = htmlspecialchars($username);
            $email_safe = htmlspecialchars($email);

            // =============================================
            // Détermination de la validité
            // =============================================
            $inscription_valide = empty($errors);
        } else {
            // Si on accède à la page sans soumettre le formulaire
            // On redirige vers le formulaire d'inscription
            header('Location: signup_form.html');
            exit();
        }
        ?>

        <?php if (!$inscription_valide): ?>
            <!-- Affichage des erreurs -->
            <div class="alert alert-danger">
                <h5>❌ Erreurs détectées</h5>
                <ul class="mb-0">
                    <?php foreach ($errors as $error): ?>
                        <li><?= htmlspecialchars($error) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>

            <!-- Re-afficher le formulaire avec données pré-remplies -->
            <div class="card p-4 mt-3">
                <p class="text-muted">Corrigez les erreurs et réessayez :</p>
                <form method="POST" action="signup_process.php">
                    <!-- Nom d'utilisateur -->
                    <div class="mb-2">
                        <input type="text"
                            class="form-control"
                            name="username"
                            placeholder="Nom d'utilisateur"
                            value="<?= $username_safe ?? '' ?>"
                            required>
                    </div>

                    <!-- Email -->
                    <div class="mb-2">
                        <input type="email"
                            class="form-control"
                            name="email"
                            placeholder="Email"
                            value="<?= $email_safe ?? '' ?>"
                            required>
                    </div>

                    <!-- Mot de passe -->
                    <div class="mb-2">
                        <input type="password"
                            class="form-control"
                            name="password"
                            placeholder="Mot de passe"
                            required>
                    </div>

                    <!-- Confirmation mot de passe -->
                    <div class="mb-2">
                        <input type="password"
                            class="form-control"
                            name="password_confirm"
                            placeholder="Confirmer le mot de passe"
                            required>
                    </div>

                    <!-- Conditions -->
                    <div class="mb-3 form-check">
                        <input type="checkbox"
                            class="form-check-input"
                            name="terms"
                            id="terms_retry"
                            <?= $terms ? 'checked' : '' ?>
                            required>
                        <label class="form-check-label" for="terms_retry">
                            J'accepte les conditions d'utilisation
                        </label>
                    </div>

                    <button type="submit" class="btn btn-primary">Réessayer l'inscription</button>
                    <a href="signup_form.html" class="btn btn-outline-secondary">Retour au formulaire</a>
                </form>
            </div>

        <?php else: ?>
            <!-- Affichage du succès -->
            <div class="alert alert-success">
                <h5>✅ Inscription réussie!</h5>
                <div class="card p-4 mt-3">
                    <h6>Compte créé :</h6>
                    <ul class="list-unstyled">
                        <li><strong>Nom d'utilisateur:</strong> <?= $username_safe ?></li>
                        <li><strong>Email:</strong> <?= $email_safe ?></li>
                        <li><strong>Inscription:</strong> <?= date('d/m/Y à H:i') ?></li>
                        <li><strong>Longueur du mot de passe:</strong> <?= strlen($password) ?> caractères</li>
                    </ul>
                    <p class="text-muted mt-3">
                        Vous êtes maintenant inscrit(e). Vous pouvez <a href="index.php" class="btn btn-success btn-sm">retourner au blog</a>
                        ou <a href="signup_form.html" class="btn btn-outline-primary btn-sm">créer un autre compte</a>.
                    </p>
                </div>

                <!-- Explication pédagogique -->
                <div class="alert alert-info mt-3">
                    <h6>🔒 Sécurité - Pourquoi htmlspecialchars()?</h6>
                    <p class="mb-2">
                        <code>htmlspecialchars()</code> est une fonction PHP qui convertit les caractères spéciaux
                        en entités HTML, empêchant ainsi les attaques XSS (Cross-Site Scripting).
                    </p>
                    <p class="mb-2">
                        Exemple: Si un attaquant saisit <code>&lt;script&gt;alert('XSS')&lt;/script&gt;</code>
                        comme nom d'utilisateur, <code>htmlspecialchars()</code> le convertit en
                        <code>&amp;lt;script&amp;gt;alert('XSS')&amp;lt;/script&amp;gt;</code>.
                    </p>
                    <p class="mb-0">
                        Résultat: Le texte s'affiche littéralement au lieu d'exécuter le code JavaScript.
                        <?php if (!preg_match('/^[a-zA-Z0-9\-]+$/', $username)): ?>
                            <br><span class="text-danger">Note: Cette entrée a été bloquée par notre validation regex,
                                mais htmlspecialchars() offre une protection supplémentaire.</span>
                        <?php endif; ?>
                    </p>
                </div>
            </div>
        <?php endif; ?>

        <!-- Informations supplémentaires -->
        <div class="card mt-4">
            <div class="card-header bg-secondary text-white">
                <h6 class="mb-0">📊 Validation du formulaire</h6>
            </div>
            <div class="card-body">
                <p><strong>Statut :</strong>
                    <?php if ($inscription_valide): ?>
                        <span class="text-success">✅ Formulaire valide</span>
                    <?php else: ?>
                        <span class="text-danger">❌ Formulaire invalide</span>
                    <?php endif; ?>
                </p>
                <p class="text-muted small mb-0">
                    Nombre d'erreurs détectées : <?= count($errors) ?>
                </p>
            </div>
        </div>
    </div>

    <script src="script.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>