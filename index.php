<?php
// ÉTAPE 1: Créer un tableau d'articles
$articles = [
  [
    'id' => 1,
    'titre' => 'Introduction à PHP',
    'contenu' => 'Découvrez les bases du langage PHP, ses variables, ses types 
de données et sa syntaxe fondamentale.',
    'auteur' => 'Alice Dupont',
    'date' => '2025-01-05',
    'categorie' => 'Tutoriels'
  ],
  [
    'id' => 2,
    'titre' => 'Les tableaux en PHP',
    'contenu' => 'Apprenez à utiliser les tableaux simples et associatifs pour 
stocker et manipuler des données.',
    'auteur' => 'Bob Martin',
    'date' => '2025-01-06',
    'categorie' => 'Tutoriels'
  ],

  [
    'id' => 3,
    'titre' => 'Ressources PHP recommandées',
    'contenu' => 'Liste des meilleurs sites et outils pour apprendre PHP en 
2025.',
    'auteur' => 'Charlie Brown',
    'date' => '2025-01-07',
    'categorie' => 'Ressources'
  ],
  [
    'id' => 4,
    'titre' => 'Les fonctions réutilisables',
    'contenu' => 'Maîtrisez la création de fonctions pour améliorer votre code 
et le rendre plus maintenable.',
    'auteur' => 'Alice Dupont',
    'date' => '2025-01-08',
    'categorie' => 'Tutoriels'
  ],
  [
    'id' => 5,
    'titre' => 'Nouvelle version de PHP 8.3',
    'contenu' => 'Découvrez les nouvelles fonctionnalités et améliorations de 
performance de PHP 8.3.',
    'auteur' => 'Fred Lopez',
    'date' => '2025-01-09',
    'categorie' => 'Actualités'
  ],
  [
    'id' => 6,
    'titre' => 'Documentation officielle PHP',
    'contenu' => 'Comment accéder et utiliser efficacement la documentation 
officielle de PHP.',
    'auteur' => 'Bob Martin',
    'date' => '2025-01-10',
    'categorie' => 'Ressources'
  ],
  [
    'id' => 7,
    'titre' => 'Bonnes pratiques PHP',
    'contenu' => 'Découvrez les standards et conventions de code pour écrire 
du PHP professionnel.',
    'auteur' => 'Charlie Brown',
    'date' => '2025-01-11',
    'categorie' => 'Tutoriels'
  ],
  [
    'id' => 8,
    'titre' => 'Conférence PHP 2025 confirmée',
    'contenu' => 'Les dates et lieux de la prochaine conférence PHP 
internationale sont annoncés.',
    'auteur' => 'Diana Lopez',
    'date' => '2025-01-12',
    'categorie' => 'Actualités'
  ]
];
// Construire la liste des auteurs uniques
$authors = [];

foreach ($articles as $article) {
  if (!in_array($article['auteur'], $authors, true)) {
    $authors[] = $article['auteur'];
  }
}

function obtenirArticlesParAuteur($articles, $auteur)
{
  return array_filter($articles, function ($article) use ($auteur) {
    return $article['auteur'] === $auteur;
  });
}



// FONCTION : Compter le nombre d'articles
function compterArticles($articles)
{
  return count($articles);
}
// FONCTION : Obtenir un article par ID
function obtenirArticleParId($articles, $id)
{
  foreach ($articles as $article) {
    if ($article["id"] === $id) {
      return $article;
    }
  }
  return null;
}
/** 
 * Filtre les articles pour retourner seulement ceux d'un auteur spécifique 
 *  
 * @param array $articles Tableau d'articles 
 * @param string $author Nom d'auteur à filtrer 
 * @return array Tableau d'articles filtrés 
 */

function filterByAuthor($articles, $author)
{
  return array_filter($articles, function ($article) use ($author) {
    return $article['auteur'] === $author;
  });
}

/** 
 * Trie les articles par date (décroissant: plus récent en premier) 
 * NOTE: usort() modifie le tableau EN PLACE 
 *  
 * @param array $articles Tableau d'articles (modifié en place) 
 * @return array Articles triés (également modifié paramètre) 
 */
function sortByDate(&$articles)
{
  usort($articles, function ($a, $b) {
    // Convertir dates en timestamps pour comparaison numérique 
    $dateA = strtotime($a['date']);
    $dateB = strtotime($b['date']);
    // Retourner: $dateB - $dateA pour DÉCROISSANT 
    // (plus récent en premier) 
    return $dateB - $dateA;
  });
  return $articles;
}



function afficherArticle($article)
{

  $titre = htmlspecialchars($article['titre']);
  $auteur = htmlspecialchars($article['auteur']);
  $contenu = htmlspecialchars($article['contenu']);
  $date = htmlspecialchars($article['date']);
  $categorie = htmlspecialchars($article['categorie']);

  return "
        <div class='col-md-4'>
            <div class='card'>
                <div class='card-body'>
                    <span class='badge bg-info'>$categorie</span>
                    <h5 class='card-title'>$titre</h5>
                    <p class='card-text'>$contenu</p>
                    <small class='text-muted'>Par $auteur - $date</small>
                    <div>
                        <a href='#' class='btn btn-primary mt-2'>Lire plus</a>
                    </div>
                </div>
            </div>
        </div>";
}

/** 
 * Extrait toutes les catégories uniques du tableau d'articles 
 *  
 * @param array $articles - Tableau contenant les articles 
 * @return array - Tableau des catégories uniques (pas de doublons) 
 */
function getCategoriesList($articles)
{

  $categories = [];

  foreach ($articles as $article) {
    // Check if category is not already in the list 
    if (!in_array($article['categorie'], $categories)) {
      $categories[] = $article['categorie'];
    }
  }

  return $categories;
}

/** 
   * Filtre les articles par catégorie 
   *  
   * @param array $articles - Tableau d'articles 
   * @param string $categorie - Catégorie à filtrer 
   * @return array - Articles filtrés 
   */
function filterByCategory($articles, $categorie)
{
  
  $filtered = [];
  if($categorie === 'Toutes'){
    return $articles;
  }
  
  foreach ($articles as $article) {
   var_dump($article['categorie'], $categorie);
    if ($article['categorie'] == $categorie) {
      var_dump("match");
      $filtered[] = $article;
    }
  
  }

  return $filtered;
}

// Récupérer le filtre optionnel depuis l'URL 
$selectedAuthor = $_GET['author'] ?? null;
var_dump($selectedAuthor);

// Appliquer le filtre si un auteur est sélectionné
if ($selectedAuthor) {
  $filtered = filterByAuthor($articles, $selectedAuthor);
} else {
  // Sinon, utiliser tous les articles 
  $filtered = $articles;
}


// Récupérer liste des catégories 
$categories = getCategoriesList($filtered);

// Déterminer catégorie sélectionnée (optionnel: par défaut "Toutes") 

$selected_category = $_GET['category'] ?? 'Toutes';

if ($selected_category) {
  $displayed_articles = filterByCategory($filtered, $selected_category);
 
} else {
  // Sinon, utiliser tous les articles filtrés par auteur
  $displayed_articles = $filtered;
}



sortByDate($displayed_articles);

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
    <h2 class="mt-5">Mes Articles</h2>

    <!-- BOUTONS DE FILTRE -->
    <div class="mb-4">
      <h5>Filtrer :</h5>
      <a href="?" class="btn btn-outline-secondary">Tous les articles</a>
      <?php foreach ($authors as $author): ?>
        <?php $isActive = ($selectedAuthor === $author) ? ' active' : ''; ?>
        <a
          href="?author=<?= urlencode($author) ?>"
          class="btn btn-outline-primary<?= $isActive ?>">
          <?= htmlspecialchars($author) ?>
        </a>
      <?php endforeach; ?>
    </div>


    <!-- Boutons de catégories -->
    <div class="category-buttons">
      <a class="btn btn-outline-primary"
         href="?category=Toutes">
        Toutes les catégories
      </a>
      <?php foreach ($categories as $cat): ?>
        <?php $isActiveCategory = ($selected_category === $cat) ? ' active' : ''; ?>
        <?php $cat_safe = htmlspecialchars($cat); ?>
        <a class="btn btn-outline-secondary <?= $isActiveCategory ?>"
          href="?category=<?= urlencode($cat_safe) ?>">
          <?= $cat_safe ?>
        </a>
      <?php endforeach; ?>
    </div>

    <!-- Grille d'articles -->
    <div class="row g-3 mt-3" id="conteneurArticles">




      <?php

      echo "<p class='text-muted'>" . count($displayed_articles) . " article(s) trouvé(s)</p>";
      // Afficher les articles 
      if (empty($displayed_articles)) {
        echo "<div class='alert alert-info'>Aucun article trouvé pour cet auteur.</div>";
      } else {
        foreach ($displayed_articles as $article) {
          echo afficherArticle($article);
        }
      }

      ?>

      <!-- Articles cachés (montrés au clic du bouton) -->
      <div class="articles-cachés" id="articlesCachés">

        <!-- Article 4 -->
        <div class="col-md-4">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title">JavaScript Basics</h5>
              <p class="card-text">JavaScript rend votre site interactif. Écoutez les clics, changez le contenu.</p>
              <a href="#" class="btn btn-primary">Lire plus</a>
            </div>
          </div>
        </div>

        <!-- Article 5 -->
        <div class="col-md-4">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Bootstrap Composants</h5>
              <p class="card-text">Bootstrap nous donne des cartes, navbars, boutons, et bien plus. Réutilisables.</p>
              <a href="#" class="btn btn-primary">Lire plus</a>
            </div>
          </div>
        </div>

        <!-- Article 6 -->
        <div class="col-md-4">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Responsive Design</h5>
              <p class="card-text">Votre blog doit s'adapter aux téléphones. CSS Media Queries le font automatiquement.</p>
              <a href="#" class="btn btn-primary">Lire plus</a>
            </div>
          </div>
        </div>

      </div>

    </div>

    <!-- Bouton pour charger plus d'articles -->
    <div class="mt-5 text-center">
      <button id="boutChargerPlus" class="btn btn-success btn-lg">Charger plus d'articles</button>
    </div>

  </div>

  <script src="script.js"></script>
</body>

</html>