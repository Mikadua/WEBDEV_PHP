// Attendre que la page soit chargée
document.addEventListener('DOMContentLoaded', function() {
  console.log('✓ Page chargée, JavaScript fonctionne!');
  
  // Trouver le bouton
  const boutChargerPlus = document.getElementById('boutChargerPlus');
  
  // Trouver les articles cachés
  const articlesCachés = document.getElementById('articlesCachés');
  
  // Variable pour tracker l'état (cachés ou visibles?)
  let articlesVisibles = false;
  
  // Écouter les clics du bouton
  boutChargerPlus.addEventListener('click', function() {
    console.log('Bouton cliqué!');
    
    // Si les articles sont cachés, les montrer
    if (articlesVisibles === false) {
      articlesCachés.style.display = 'contents';
      boutChargerPlus.textContent = 'Masquer les articles';
      articlesVisibles = true;
      console.log('Articles affichés');
    }
    // Si les articles sont visibles, les cacher
    else {
      articlesCachés.style.display = 'none';
      boutChargerPlus.textContent = 'Charger plus d\'articles';
      articlesVisibles = false;
      console.log('Articles cachés');
    }
  });
});
