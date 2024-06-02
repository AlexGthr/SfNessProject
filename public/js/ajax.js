document.addEventListener("DOMContentLoaded", function() {
    let linksPanier = document.querySelectorAll('button.js-addPanier');

    if (linksPanier) {
        linksPanier.forEach(link => {
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

document.addEventListener("DOMContentLoaded", function() {
    let linksAddQuantity = document.querySelectorAll('button.addQuantity');

    if (linksAddQuantity) {
        linksAddQuantity.forEach(link => {
            link.addEventListener("click", function(event) {
                console.log("ok");

                event.preventDefault();

                let idProduct = link.dataset.id;
                const url = `/panier/addQuantity/${idProduct}`;

                axios.get(url)
                    .then(function(response) {
                        console.log(response);
                        if (response.data.code === 200) {
                            console.log("+1");
                            let quantitySpan = link.closest('td').querySelector('span.quantityProduct');
                            let totalPriceItems = link.closest('tr').querySelector('span.totalPriceItems');
                            let totalPanier = document.querySelector('span.totalPanier');
                            console.log(response.data.totalPriceItem)
                            quantitySpan.textContent = response.data.quantity;
                            totalPriceItems.textContent = response.data.totalPriceItem + " €";
                            totalPanier.textContent = response.data.total + " €";
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