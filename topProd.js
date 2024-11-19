document.addEventListener("DOMContentLoaded", () => {
    const productContainer = document.getElementById("product-container");

    const fetchProducts = (status = '') => {
        // Fetch products from the backend with the selected status
        fetch(`http://localhost/Ecom/public/fetchProducts.php?status=${status}`)
            .then(response => response.json())
            .then(data => {
                if (data.error) {
                    throw new Error(data.error);
                }
                console.log(data);
                displayProducts(data);
            })
            .catch(error => {
                console.error("Error fetching products:", error);
                productContainer.innerHTML = "<p>Failed to load products.</p>";
            });
    };

    const displayProducts = (products) => {
        productContainer.innerHTML = '';
        products.forEach(product => {
            const productCard = document.createElement("div");
            productCard.classList.add("product-card");

            productCard.innerHTML = `
                <img src="${product.image}" alt="${product.name}">
                <h3>${product.name}</h3>
                <p class="price">$${product.price}</p>
            `;
            productContainer.appendChild(productCard);
        });
    };

    // Initial fetch
    fetchProducts();

    // Event listeners for category buttons
    const buttons = document.querySelectorAll('.category-buttons button');
    buttons.forEach(button => {
        button.addEventListener("click", (event) => {
            // Remove active class from all buttons
            buttons.forEach(btn => btn.classList.remove('active'));

            // Add active class to the clicked button
            event.target.classList.add('active');

            // Fetch products based on selected category
            const status = event.target.id.replace('-btn', '');
            fetchProducts(status);
        });
    });
});
