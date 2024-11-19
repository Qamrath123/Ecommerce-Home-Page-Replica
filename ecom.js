
$(document).ready(function(){
    $(".owl-carousel.custom-owl-theme").owlCarousel({
        loop: true,             // Infinite loop
        margin: 20,             // Space between items
        nav: false,             // Show navigation arrows
        dots: false,            // Disable dots navigation
        autoplay: true,         // Enable autoplay
        autoplayTimeout: 3000,  // Time between slides (3 seconds)
        autoplayHoverPause: true, // Pause autoplay on hover
        responsive: {           // Responsive breakpoints
            0: {
                items: 2        // Show 2 items on small screens
            },
            600: {
                items: 4        // Show 4 items on medium screens
            },
            1000: {
                items: 6        // Show 6 items on large screens
            }
        }
    });
});

$(document).ready(function() {
    // Fetch Testimonials from Backend
    $.ajax({
        url: 'http://localhost/Ecom/public/fetch_testimonials.php', // Replace with the correct path to your PHP file
        method: 'GET',
        dataType: 'json',
        success: function(response) {
            // Loop through the testimonials and create HTML structure
            response.forEach(testimonial => {
                const testimonialHTML = `
                    <div class="item">
                        <div class="quotes-slider__text">
                            <img src="${testimonial.image_url}" alt="${testimonial.name}">
                            <p>${testimonial.message}</p>
                            <div class="testibox">
                                <h4>${testimonial.name}</h4>
                                <h5>${testimonial.designation}</h5>
                            </div>
                        </div>
                    </div>
                `;
                $('.testi').append(testimonialHTML);
            });

            // Initialize Owl Carousel after content is loaded
            $('.testi').owlCarousel({
                items: 1,
                loop: true,
                autoplay: true,
                autoplayTimeout: 3000,
                autoplayHoverPause: true,
                nav: false,
                dots: false
            });
        },
        error: function(error) {
            console.error('Error fetching testimonials:', error);
        }
    });
});

// Select necessary elements
const slides = document.querySelectorAll('.slide');
const dots = document.querySelectorAll('.dot');
let currentSlide = 0;
const totalSlides = slides.length;

// Function to show the selected slide
function showSlide(index) {
    // Hide all slides
    slides.forEach(slide => slide.classList.remove('active'));
    dots.forEach(dot => dot.classList.remove('active'));
    
    // Show selected slide
    slides[index].classList.add('active');
    dots[index].classList.add('active');
    currentSlide = index;
}

// Add click event listeners to dots
dots.forEach((dot, index) => {
    dot.addEventListener('click', () => {
        showSlide(index);
    });
});

// Function to show the next slide automatically
function nextSlide() {
    currentSlide = (currentSlide + 1) % totalSlides;
    showSlide(currentSlide);
}

// Set interval to move to the next slide every 5 seconds
setInterval(nextSlide, 5000);

// Initial display
showSlide(currentSlide);

  const countrySelect = document.getElementById('country-select');

  // Array of countries with flag codes and currency codes
  const countries = [
    { code: 'IN', currency: 'INR', flag: '🇮🇳' },
    { code: 'US', currency: 'USD', flag: '🇺🇸' },
    { code: 'EU', currency: 'EUR', flag: '🇪🇺' },
    // Add more countries as needed
  ];
  
  countries.forEach(country => {
    const option = document.createElement('option');
    option.value = country.code;
    option.innerHTML = `${country.flag} ${country.currency}`;
    countrySelect.appendChild(option);
  });


  //Fetch top products
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

//Close button Modal
function closeDeal() {
    document.getElementById('dealContainer').style.display = 'none';
}
    let currentDealIndex = 0;

    // Fetch deals and render dynamically
    fetch('http://localhost/Ecom/public/getActiveDeal.php')
        .then(response => response.json())
        .then(deals => {
            const container = document.querySelector('.deals-container');
            container.innerHTML = ''; // Clear container

            deals.forEach(deal => {
                const card = document.createElement('div');
                card.className = 'deal-card';
                card.innerHTML = `
                    <img src="${deal.image_url}" alt="${deal.product_name}">
                    <div class="details">
                        <h3>${deal.product_name}</h3>
                         <p class="description">${deal.description}</p> <!-- Description after title -->
                        <p class="price">
                            <span class="original">Rs. ${deal.original_price}</span>
                            <span class="discounted">Rs. ${deal.discounted_price}</span>
                        </p>
                    </div>
                    <div class="product-icons">
                        <span class="icon-wishlist" title="Add to Wishlist">❤️</span>
                        <span class="icon-cart" title="Add to Cart">🛒</span>
                        <span class="icon-eye quick-view" title="Quick View" 
                              data-title="${deal.product_name}" 
                              data-description="${deal.description}" 
                              data-image="${deal.image_url}"
                              data-price="${deal.discounted_price}"
                              data-availability="${deal.availability}"
                              data-size="${deal.size}"
                              data-color="${deal.color}"
                              data-quantity="${deal.quantity}">👁️</span>
                    </div>
                `;
                container.appendChild(card);
            });

            // Event listener for quick view modal
            document.querySelectorAll('.quick-view').forEach(item => {
                item.addEventListener('click', function() {
                    const title = this.getAttribute('data-title');
                    const description = this.getAttribute('data-description');
                    const image = this.getAttribute('data-image');
                    const price = this.getAttribute('data-price');
                    const availability = this.getAttribute('data-availability');
                    const size = this.getAttribute('data-size');
                    const color = this.getAttribute('data-color');
                    const quantity = this.getAttribute('data-quantity');
                    
                    toggleOverviewModal(title, description, image, price, availability, size, color, quantity);
                });
            });

           

            // // Prev/Next Button Logic
            // document.getElementById('prev-btn').addEventListener('click', () => {
            //     if (currentDealIndex > 0) {
            //         currentDealIndex -= 2;
            //         renderDealOfTheDay();
            //     }
            // });

            // document.getElementById('next-btn').addEventListener('click', () => {
            //     if (currentDealIndex + 2 < deals.length) {
            //         currentDealIndex += 2;
            //         renderDealOfTheDay();
            //     }
            // });
        })
        .catch(error => {
            console.error('Error fetching deals:', error);
        });

    // Toggle overview modal
    function toggleOverviewModal(title = '', description = '', image = '', price = '', availability = '', size = '', color = '', quantity = '') {
        const modal = document.getElementById('overview-modal');
        const modalTitle = document.getElementById('modal-title');
        const modalDescription = document.getElementById('modal-description');
        const modalImage = document.getElementById('modal-image');
        const modalPrice = document.getElementById('modal-price');
        const modalAvailability = document.getElementById('modal-availability');
        const modalSize = document.getElementById('modal-size');
        const modalColor = document.getElementById('modal-color');
        const modalQuantity = document.getElementById('modal-quantity');

        if (modal.classList.contains('active')) {
            // Close modal
            modal.classList.remove('active');
        } else {
            // Open modal and populate data
            modalTitle.textContent = title;
            modalDescription.textContent = description;
            modalImage.src = image;
            modalPrice.textContent = `$${price}`;
            modalAvailability.textContent = availability;
            modalSize.textContent = size;
            modalColor.textContent = color;
            modalQuantity.textContent = quantity;

            modal.classList.add('active');
        }
    }


    //FETCH ON SALE  PRODUCTS
     document.addEventListener("DOMContentLoaded", () => {
        const sliderTrack = document.getElementById("slider-track");
        const prevBtn = document.getElementById("prev-btn");
        const nextBtn = document.getElementById("next-btn");
        let currentPosition = 0;

        const fetchProducts = () => {
            fetch("http://localhost/Ecom/public/get_on_sale.php") // Replace with your API endpoint
                .then(response => response.json())
                .then(products => {
                    displayProducts(products);
                })
                .catch(error => {
                    console.error("Error fetching products:", error);
                });
        };

        const displayProducts = (products) => {
            sliderTrack.innerHTML = ''; // Clear previous content

            if (products.length === 0) {
                sliderTrack.innerHTML = "<p>No products found.</p>";
                return;
            }

            products.forEach(product => {
                const productCard = document.createElement("div");
                productCard.classList.add("product-card");

                productCard.innerHTML = `
                    <img src="${product.image_url}" alt="${product.name}">
                    <h3>${product.name}</h3>
                    <p class="price">Original: $${product.price}</p>
                    <p class="sale-price">Sale: $${product.sale_price}</p>
                    ${product.is_sold_out ? '<p class="sold-out">Sold Out</p>' : ''}
                `;
                sliderTrack.appendChild(productCard);
            });
        };

        const moveSlider = (direction) => {
            const slideWidth = 320; // Product card width + margin
            const maxPosition = -(sliderTrack.children.length * slideWidth - document.querySelector(".slider-container2").clientWidth);

            currentPosition += direction * slideWidth;
            if (currentPosition > 0) currentPosition = 0;
            if (currentPosition < maxPosition) currentPosition = maxPosition;

            sliderTrack.style.transform = `translateX(${currentPosition}px)`;
        };

        prevBtn.addEventListener("click", () => moveSlider(1));
        nextBtn.addEventListener("click", () => moveSlider(-1));

        fetchProducts();
    });




    //LATEST BLOG 

    document.addEventListener('DOMContentLoaded', () => {
            const slider = document.getElementById('slider');
            const errorMessage = document.getElementById('errorMessage');
            let currentIndex = 0;

            // Fetch blogs from backend
            fetch('http://localhost/Ecom/public/fetchBlog.php')
                .then(response => response.json())
                .then(data => {
                    if (data.length === 0) {
                        errorMessage.textContent = "No blogs available.";
                        return;
                    }

                    // Loop through the fetched blogs and add to the slider
                    data.forEach(blog => {
                        const slide = document.createElement('div');
                        slide.className = 'slide1';
                        slide.innerHTML = `
                            <div class="image-container">
                                <img src="${blog.image_url}" alt="${blog.title}">
                            </div>
                            <div class="content-wrapper">
                                <p class="date"> ${new Date(blog.date_posted).toLocaleDateString("en-US", { year: 'numeric', month: 'short', day: 'numeric' })}</p>
                                <h3>${blog.title}</h3> <!-- Title with hover effect -->
                                <p>${blog.content.substring(0, 100)}...</p>
                                <a href="blogDetails.php?id=${blog.id}" class="read-more">Read More</a>
                            </div>
                        `;
                        slider.appendChild(slide);
                    });

                    // Adjust slider to the first slide
                    updateSliderPosition();
                })
                .catch(error => {
                    errorMessage.textContent = "Error loading blogs. Please try again later.";
                    console.error(error);
                });

            // Slider control buttons
            const prevBtn = document.getElementById('prevBtn');
            const nextBtn = document.getElementById('nextBtn');

            prevBtn.addEventListener('click', () => {
                currentIndex = (currentIndex === 0) ? slider.children.length - 1 : currentIndex - 1;
                updateSliderPosition();
            });

            nextBtn.addEventListener('click', () => {
                currentIndex = (currentIndex === slider.children.length - 1) ? 0 : currentIndex + 1;
                updateSliderPosition();
            });

            // Update slider position
            function updateSliderPosition() {
                slider.style.transform = `translateX(-${currentIndex * 50}%)`;
            }
        });

     
     
   
    
    
    