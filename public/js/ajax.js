document.addEventListener("DOMContentLoaded", function() {
    let links = document.querySelectorAll('button.js-addPanier');

    if (links) {
        links.forEach(link => {
            link.addEventListener("click", function(event) {
                console.log("ok");

                event.preventDefault();

                let idProduct = link.dataset.id;
                let textPanier = link.querySelector('span.addPanier');
                const url = `/panier/add/${idProduct}`;

                axios.get(url)
                    .then(function(response) {
                        console.log(response);
                        if (response.data.code === 200) {
                            textPanier.textContent = "Produit ajouté au panier";
                        } else {
                            console.error('Erreur lors de l\'ajout au panier');
                        }
                    })
                    .catch(function(error) {
                        console.error('Erreur lors de la requête AJAX', error);
                    });
            });
        });
    }
});