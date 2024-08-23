<?php

use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Markup;
use Twig\Sandbox\SecurityError;
use Twig\Sandbox\SecurityNotAllowedTagError;
use Twig\Sandbox\SecurityNotAllowedFilterError;
use Twig\Sandbox\SecurityNotAllowedFunctionError;
use Twig\Source;
use Twig\Template;

/* productfetcher.html.twig */
class __TwigTemplate_7161819ccc2ec429286741212b45e060160b19793e909486bbea19feeecf140f extends \Twig\Template
{
    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = [
            'content' => [$this, 'block_content'],
        ];
    }

    protected function doDisplay(array $context, array $blocks = [])
    {
        // line 1
        $this->displayBlock('content', $context, $blocks);
    }

    public function block_content($context, array $blocks = [])
    {
        // line 2
        echo "<h1 class=\"title-shop py-4\">Products</h1>

<!-- Loading spinner -->
<div id=\"loading\" class=\"text-center my-5\">
    <div class=\"spinner-border text-primary mt-2\" role=\"status\">
        <span class=\"sr-only\"></span>
    </div>
    <span class=\"mx-2\">Loading! Please wait...</span>
</div>

<!-- Product grid container -->
<div id=\"product-grid\" class=\"row\" style=\"display: none;\"></div> 

<script>
    document.addEventListener('DOMContentLoaded', function() {
        fetch('https://fakestoreapi.com/products')
            .then(response => response.json())
            .then(products => {
                const productGrid = document.getElementById('product-grid');
                const loading = document.getElementById('loading');

                products.forEach(product => {
                    const productItem = document.createElement('div');
                    productItem.classList.add('col-md-4', 'mb-4');
                    productItem.innerHTML = `
                        <div class=\"card\">
                            <div class=\"main-images\">
                                <img src=\"\${product.image}\" alt=\"\${product.title}\">
                            </div>
                            <div class=\"card-body px-0\">
                                <div class=\"details\">
                                    <span class=\"p_name\">\${product.title}</span>
                                </div>
                            </div>
                            <div class=\"price\">
                                <span class=\"price_num\">\$ \${product.price}</span>
                            </div>
                            <div class=\"button\">
                                <a href=\"/product?id=\${product.id}\">
\t\t\t\t\t\t\t\t\t\t<button>Details</button>
\t\t\t\t\t\t\t\t\t</a>

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
";
    }

    public function getTemplateName()
    {
        return "productfetcher.html.twig";
    }

    public function getDebugInfo()
    {
        return array (  37 => 2,  31 => 1,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Source("{% block content %}
<h1 class=\"title-shop py-4\">Products</h1>

<!-- Loading spinner -->
<div id=\"loading\" class=\"text-center my-5\">
    <div class=\"spinner-border text-primary mt-2\" role=\"status\">
        <span class=\"sr-only\"></span>
    </div>
    <span class=\"mx-2\">Loading! Please wait...</span>
</div>

<!-- Product grid container -->
<div id=\"product-grid\" class=\"row\" style=\"display: none;\"></div> 

<script>
    document.addEventListener('DOMContentLoaded', function() {
        fetch('https://fakestoreapi.com/products')
            .then(response => response.json())
            .then(products => {
                const productGrid = document.getElementById('product-grid');
                const loading = document.getElementById('loading');

                products.forEach(product => {
                    const productItem = document.createElement('div');
                    productItem.classList.add('col-md-4', 'mb-4');
                    productItem.innerHTML = `
                        <div class=\"card\">
                            <div class=\"main-images\">
                                <img src=\"\${product.image}\" alt=\"\${product.title}\">
                            </div>
                            <div class=\"card-body px-0\">
                                <div class=\"details\">
                                    <span class=\"p_name\">\${product.title}</span>
                                </div>
                            </div>
                            <div class=\"price\">
                                <span class=\"price_num\">\$ \${product.price}</span>
                            </div>
                            <div class=\"button\">
                                <a href=\"/product?id=\${product.id}\">
\t\t\t\t\t\t\t\t\t\t<button>Details</button>
\t\t\t\t\t\t\t\t\t</a>

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
{% endblock %}
", "productfetcher.html.twig", "/var/www/html/user/themes/product-theme/templates/productfetcher.html.twig");
    }
}
