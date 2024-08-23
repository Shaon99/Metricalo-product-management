<h1 class="title-shop py-4">Products</h1>

<!-- Loading spinner -->
<div id="loading" class="text-center my-5">
    <div class="spinner-border text-primary mt-2" role="status">
        <span class="sr-only"></span>
    </div>
    <span class="mx-2">Loading! Please wait...</span>
</div>

<!-- Product grid container -->
<div id="product-grid" class="row" style="display: none;"></div> 

<script>
    document.addEventListener('DOMContentLoaded', function() {
        fetch('http://localhost:8000/api/products')
            .then(response => response.json())
            .then(products => {
                const productGrid = document.getElementById('product-grid');
                const loading = document.getElementById('loading');

                products.forEach(product => {
                    const productItem = document.createElement('div');
                    productItem.classList.add('col-md-4', 'mb-4');
                    productItem.innerHTML = `
                        <div class="card">
                            <div class="main-images">
                                <img src="${product.image}" alt="${product.name}">
                            </div>
                            <div class="card-body px-0">
                                <div class="details">
                                    <span class="p_name">${product.name}</span>
                                </div>
                            </div>
                            <div class="price">
                                <span class="price_num">$${product.price}</span>
                            </div>
                            <div class="button">
                                <a href="/product?id=${product.id}">
										<button>Details</button>
									</a>

                            </div>
                        </div>
                    `;
                    productGrid.appendChild(productItem);
                });

                loading.style.display = 'none';
                productGrid.style.display = 'flex';
            })
            .catch(error => {
                console.error('Error fetching products:', error);
            });
    });
</script>
