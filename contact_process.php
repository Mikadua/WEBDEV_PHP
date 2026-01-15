<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Initialiser tableau pour les erreurs
    $errors = [];


    // Étape 1: Récupérer et nettoyer les données
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $message = trim($_POST['message'] ?? '');



    // --- VALIDATION COUCHE 1: CHAMPS OBLIGATOIRES ---
    if (empty($name)) {
        $errors[] = "Le nom est requis";
    }
    if (empty($email)) {
        $errors[] = "L'email est requis";
    }
    if (empty($message)) {
        $errors[] = "Le message ne peut pas être vide";
    }

    // --- VALIDATION COUCHE 2: FORMAT VALIDE ---
    // Valider seulement si Couche 1 est OK
    if (empty($errors)) {
        // Vérifier la longueur du nom
        if (strlen($name) < 2) {
            $errors[] = "Le nom doit contenir au moins 2 caractères";
        }
        // Vérifier le format de l'email
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = "L'adresse email n'est pas valide (format: user@domain.com)";
        }
        // Vérifier la longueur du message
        if (strlen($message) < 10) {
            $errors[] = "Le message doit contenir au moins 10 caractères";
        }
    }



?>





<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mon Blog</title>

    <!-- Bootstrap CSS depuis CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="style.css">
</head>

<body>

    <!-- Navbar Bootstrap -->
    <nav class="navbar navbar-dark bg-dark">
        <div class="container-fluid">
            <span class="navbar-brand">Mon Blog</span>
        </div>
    </nav>

    <!-- Contenu principal -->
    <div class="container mt-5">
        <h1>Mon Blog</h1>
        <p>Bienvenue sur mon blog. Découvrez mes articles.</p>

        <!-- Section: Articles -->
        <h2 class="mt-5">Confirmation d'envoi de message</h2>
        <?php
       
          if(!empty($errors)) {
               echo  '<div class="error-list">';
               foreach ($errors as $error){
                    echo '<div class="alert alert-danger" role="alert">' . $error . '</div>';
               }
                 
                echo '</div>';


          } else {
            
            echo "<p>Merci, <strong>$name</strong>, pour votre message. Nous vous répondrons sous peu.</p>"; 
          }
        
        ?>
    </div>



    </div>

    <script src="script.js"></script>
</body>

</html>
<?php }?>