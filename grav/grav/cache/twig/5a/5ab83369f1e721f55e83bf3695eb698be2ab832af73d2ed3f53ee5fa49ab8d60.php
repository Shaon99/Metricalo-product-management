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

/* partials/productfetcher.html.twig */
class __TwigTemplate_8faa5bf0a65adccd64754d91d0dad3dea507f489c5eab717433d8e956ddb524b extends \Twig\Template
{
    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = [
        ];
    }

    protected function doDisplay(array $context, array $blocks = [])
    {
        // line 1
        echo "<div class=\"container\">
    <h1 class=\"title-shop mb-4\">Products</h1>
    <div id=\"product-grid\" class=\"row\">
        ";
        // line 4
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(($context["products"] ?? null));
        foreach ($context['_seq'] as $context["_key"] => $context["product"]) {
            // line 5
            echo "            <div class=\"col-md-4 mb-4\">
                <div class=\"card h-100\">
                    <img src=\"";
            // line 7
            echo twig_escape_filter($this->env, $this->getAttribute($context["product"], "image", []), "html", null, true);
            echo "\" class=\"card-img-top\" alt=\"";
            echo twig_escape_filter($this->env, $this->getAttribute($context["product"], "title", []), "html", null, true);
            echo "\">
                    <div class=\"card-body\">
                        <h5 class=\"card-title\">";
            // line 9
            echo twig_escape_filter($this->env, $this->getAttribute($context["product"], "title", []), "html", null, true);
            echo "</h5>
                        <p class=\"card-text\">";
            // line 10
            echo twig_escape_filter($this->env, twig_slice($this->env, $this->getAttribute($context["product"], "description", []), 0, 100), "html", null, true);
            echo "...</p>
                        <p class=\"card-text\"><strong>Price: \$";
            // line 11
            echo twig_escape_filter($this->env, $this->getAttribute($context["product"], "price", []), "html", null, true);
            echo "</strong></p>
                    </div>
                    <div class=\"card-footer\">
                        <a href=\"#\" class=\"btn btn-primary\">View Details</a>
                    </div>
                </div>
            </div>
        ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['product'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 19
        echo "    </div>
</div>
";
    }

    public function getTemplateName()
    {
        return "partials/productfetcher.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  72 => 19,  58 => 11,  54 => 10,  50 => 9,  43 => 7,  39 => 5,  35 => 4,  30 => 1,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Source("<div class=\"container\">
    <h1 class=\"title-shop mb-4\">Products</h1>
    <div id=\"product-grid\" class=\"row\">
        {% for product in products %}
            <div class=\"col-md-4 mb-4\">
                <div class=\"card h-100\">
                    <img src=\"{{ product.image }}\" class=\"card-img-top\" alt=\"{{ product.title }}\">
                    <div class=\"card-body\">
                        <h5 class=\"card-title\">{{ product.title }}</h5>
                        <p class=\"card-text\">{{ product.description[:100] }}...</p>
                        <p class=\"card-text\"><strong>Price: \${{ product.price }}</strong></p>
                    </div>
                    <div class=\"card-footer\">
                        <a href=\"#\" class=\"btn btn-primary\">View Details</a>
                    </div>
                </div>
            </div>
        {% endfor %}
    </div>
</div>
", "partials/productfetcher.html.twig", "/var/www/html/user/themes/product-theme/templates/partials/productfetcher.html.twig");
    }
}
