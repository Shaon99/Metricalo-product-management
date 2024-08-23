---
title: "Product Details"
---

  <div class="row gx-5 py-4">
  <div id="loading" class="text-center my-5">
    <div class="spinner-border text-primary mt-2" role="status">
        <span class="sr-only"></span>
    </div>
    <span class="mx-2">Loading! Please wait...</span>
  </div>
      <aside class="col-lg-6">
        <div class="mb-3 d-flex justify-content-center">
           <img id="product-img" 
            src="" 
            class="rounded-4 fit mx-auto"
            style="max-width: 100%; max-height: 80vh; object-fit: cover; display: block;" />
        </div>
      </aside>
      <main class="col-lg-6">
        <div class="ps-lg-3">
          <h4 class="title text-dark" id="product-title">
          </h4>
          <div class="d-flex flex-row my-3">
                <span class="h4" id="price"></span>
          </div>
          <div class="my-3">
          <p id="description">
          </p>
          <div>
          <div class="py-3">
            <a href="/" class="btn btn-primary rounded" id="backBtn">Back To Home</a>
          </div>
        </div>
      </main>
    </div>

  </div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const urlParams = new URLSearchParams(window.location.search);
        const productId = urlParams.get('id');
        const loading = document.getElementById('loading');

        if (productId) {
            fetch(`http://localhost:8000/api/product/${productId}`)
                .then(response => response.json())
                .then(product => {
                    loading.style.display = 'none';
                    document.getElementById('product-title').innerText = product.name;
                    document.getElementById('description').innerText = product.description;
                    document.getElementById('price').innerText = `$${product.price}`;
                    document.getElementById('product-img').src = product.image;
                })
                .catch(error => {
                    console.error('Error fetching product details:', error);
                });
        } else {
            console.error('No product ID found in the URL');
        }
    });
</script>
