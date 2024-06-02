// On attend que la page soit complétement charger
document.addEventListener("DOMContentLoaded", function() {
    // Je récupère tout mes button js-addPanier
    let linksPanier = document.querySelectorAll('button.js-addPanier');

    // Si mon linksPanier existe, alors je travail dessus :
    if (linksPanier) {

        // Je crée une boucle pour pouvoir intéragir sur chaque éléments de mon linksPanier et j'attribue la variable link à ses éléments
        linksPanier.forEach(link => {
            // Lorsque que l'ont clique sur élément link, on crée un événement :
            link.addEventListener("click", function(event) {

                // J'utilise la method preventDefault pour éviter un rechargement de la page
                event.preventDefault();

                // Je récupère l'id du produit donner par mon dataset
                let idProduct = link.dataset.id;
                // Je récupère le texte "Ajouter au panier"
                let textPanier = link.querySelector('span.addPanier');
                // Je défini l'url d'action
                const url = `/panier/add/${idProduct}`;

                // J'utilise la librairie AXIOS pour crée une requete AJAX en lui indiquant l'url d'action (Method de mon controller pour ajouté un produit dans le panier)
                axios.get(url)
                    .then(function(response) { // Lorsque j'ai une réponse d'AXIOS :

                        // Si je reçois un code "200" (Tout s'est bien déroulé)
                        if (response.data.code === 200) {
                            // Je modifie le texte de mon span pour indiqué à l'utilisateur que tout s'est bien déroulé
                            textPanier.textContent = "Produit ajouté au panier";
                        } else {
                            // Sinon j'informe d'une erreur dans ma console
                            console.error('Erreur lors de l\'ajout au panier');
                        }
                    })
                    .catch(function(error) { // Si je n'ai pas eu de réponse, j'informe dans ma console de l'erreur
                        console.error('Erreur lors de la requête AJAX', error);
                    });
            });
        });
    }
});

// On attend que la page soit complétement charger
document.addEventListener("DOMContentLoaded", function() {
        // Je récupère mon button js-addQuantity
    let linksAddQuantity = document.querySelectorAll('button.addQuantity');

    // Si mon linksAddQuantity existe, alors je travail dessus :
    if (linksAddQuantity) {

        // Je crée une boucle pour pouvoir intéragir sur chaque éléments de mon linksAddQuantity et j'attribue la variable link à ses éléments       
        linksAddQuantity.forEach(link => {
            // Lorsque que l'ont clique sur élément link, on crée un événement :
            link.addEventListener("click", function(event) {

                // J'utilise la method preventDefault pour éviter un rechargement de la page                
                event.preventDefault();

                // Je récupère l'id du produit donner par mon dataset
                let idProduct = link.dataset.id;
                // Je défini l'url d'action
                const url = `/panier/addQuantity/${idProduct}`;

                // J'utilise la librairie AXIOS pour crée une requete AJAX en lui indiquant l'url d'action (Method de mon controller pour ajouté une quantité dans le panier)
                axios.get(url)
                    .then(function(response) { // Lorsque j'ai une réponse d'AXIOS :

                        // Si je reçois un code "200" (Tout s'est bien déroulé)
                        if (response.data.code === 200) {

                            // Je récupère mon span qui affiche la quantité sur ma page avec la method "closest"
                            let quantitySpan = link.closest('td').querySelector('span.quantityProduct');
                            // Je récupère mon span qui affiche le prix total d'un produit sur ma page avec la method "closest"
                            let totalPriceItems = link.closest('tr').querySelector('span.totalPriceItems');
                            // Je récupère mon span qui affiche le prix total du panier sur ma page
                            let totalPanier = document.querySelector('span.totalPanier');

                            // Je modifie la nouvelle quantité sur ma page
                            quantitySpan.textContent = response.data.quantity;
                            // Je modifie le nouveau prix total d'un produit sur ma page
                            totalPriceItems.textContent = response.data.totalPriceItem + " €";
                            // Je modifie le prix total du panier sur ma page
                            totalPanier.textContent = response.data.total + " €";

                        } else { // Sinon j'informe dans ma console l'erreur
                            console.error('Erreur lors de l\'ajout au panier');
                        }
                    })
                    .catch(function(error) { // Si pas de réponse d'axios, j'informe de l'erreur dans ma console
                        console.error('Erreur lors de la requête AJAX', error);
                    });
            });
        });
    }
});

// On attend que la page soit complétement charger
document.addEventListener("DOMContentLoaded", function() {
    // Je récupère mon button js-downQuantity
    let linksDownQuantity = document.querySelectorAll('button.downQuantity');

    // Si mon linksDownQuantity existe, alors je travail dessus :
    if (linksDownQuantity) {
        // Je crée une boucle pour pouvoir intéragir sur chaque éléments de mon linksDownQuantity et j'attribue la variable link à ses éléments 
        linksDownQuantity.forEach(link => {
            // Lorsque que l'ont clique sur élément link, on crée un événement :
            link.addEventListener("click", function(event) {

                // J'utilise la method preventDefault pour éviter un rechargement de la page 
                event.preventDefault();

                // Je récupère l'id du produit donner par mon dataset
                let idProduct = link.dataset.id;
                // Je défini l'url d'action
                const url = `/panier/downQuantity/${idProduct}`;

                // J'utilise la librairie AXIOS pour crée une requete AJAX en lui indiquant l'url d'action (Method de mon controller pour ajouté une quantité dans le panier)
                axios.get(url)
                    .then(function(response) { // Lorsque j'ai une réponse d'AXIOS :

                        // Si je reçois un code "200" (Tout s'est bien déroulé)
                        if (response.data.code === 200) {

                            // Je récupère mon span qui affiche la quantité sur ma page avec la method "closest"
                            let quantitySpan = link.closest('td').querySelector('span.quantityProduct');

                                // Si ma quantité est à 0 (null)
                                if (response.data.quantity === null) {

                                    // Alors je récupère ma ligne du tableau et je la supprime
                                    deleteData = link.closest('tr');
                                    deleteData.remove();

                                } else { // Si ma quantité est supérieur à 0 :

                                    // Je récupère mon span qui affiche le prix total d'un produit sur ma page avec la method "closest"
                                    let totalPriceItems = link.closest('tr').querySelector('span.totalPriceItems');
                                    // Je récupère mon span qui affiche le prix total du panier sur ma page
                                    let totalPanier = document.querySelector('span.totalPanier');
                                    
                                    // Je modifie la nouvelle quantité sur ma page
                                    quantitySpan.textContent = response.data.quantity;
                                    // Je modifie le nouveau prix total d'un produit sur ma page
                                    totalPriceItems.textContent = response.data.totalPriceItem + " €";
                                    // Je modifie le prix total du panier sur ma page
                                    totalPanier.textContent = response.data.total + " €";
                                }
                        } else { // Sinon j'informe dans ma console l'erreur
                            console.error('Erreur lors de l\'ajout au panier');
                        }
                    })
                    .catch(function(error) { // Si pas de réponse d'axios, j'informe de l'erreur dans ma console
                        console.error('Erreur lors de la requête AJAX', error);
                    });
            });
        });
    }
});