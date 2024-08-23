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

/* partials/base.html.twig */
class __TwigTemplate_6e7195a5d9b1173224e6183f3a08824c826a8fd0d0688873a02fa712c9cde5c7 extends \Twig\Template
{
    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = [
            'stylesheets' => [$this, 'block_stylesheets'],
            'content' => [$this, 'block_content'],
            'javascripts' => [$this, 'block_javascripts'],
        ];
    }

    protected function doDisplay(array $context, array $blocks = [])
    {
        // line 1
        echo "<!DOCTYPE html>
<html>
\t<head>
\t\t<meta charset=\"utf-8\"/>
\t\t<title>
\t\t\t";
        // line 6
        if ($this->getAttribute(($context["page"] ?? null), "title", [])) {
            // line 7
            echo "\t\t\t\t";
            echo twig_escape_filter($this->env, $this->getAttribute(($context["page"] ?? null), "title", []), "html");
            echo "
\t\t\t\t|
\t\t\t";
        }
        // line 10
        echo "\t\t\t";
        echo twig_escape_filter($this->env, $this->getAttribute(($context["site"] ?? null), "title", []), "html");
        echo "</title>

\t\t<meta http-equiv=\"X-UA-Compatible\" content=\"IE=edge\">
\t\t<meta name=\"viewport\" content=\"width=device-width, initial-scale=1\">
\t\t";
        // line 14
        $this->displayBlock('stylesheets', $context, $blocks);
        // line 21
        echo "\t</head>
\t<body>
\t\t<header>
\t\t\t";
        // line 24
        $this->loadTemplate("partials/navbar.html.twig", "partials/base.html.twig", 24)->display($context);
        // line 25
        echo "\t\t</header>

\t\t<main class=\"container\"> ";
        // line 27
        $this->displayBlock('content', $context, $blocks);
        // line 28
        echo "\t\t\t</main>

\t\t\t";
        // line 30
        $this->loadTemplate("partials/footer.html.twig", "partials/base.html.twig", 30)->display($context);
        // line 31
        echo "
\t\t\t";
        // line 32
        $this->displayBlock('javascripts', $context, $blocks);
        // line 35
        echo "
\t\t</body>
\t</html>
";
    }

    // line 14
    public function block_stylesheets($context, array $blocks = [])
    {
        // line 15
        echo "\t\t\t<!-- CSS -->
\t\t\t<link
\t\t\trel=\"stylesheet\" href=\"";
        // line 17
        echo twig_escape_filter($this->env, $this->env->getExtension('Grav\Common\Twig\Extension\GravExtension')->urlFunc("theme://css/style.css"), "html", null, true);
        echo "\">
\t\t\t<!-- Bootstrap CSS from CDN -->
\t\t\t<link href=\"https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css\" rel=\"stylesheet\" integrity=\"sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH\" crossorigin=\"anonymous\">
\t\t";
    }

    // line 27
    public function block_content($context, array $blocks = [])
    {
    }

    // line 32
    public function block_javascripts($context, array $blocks = [])
    {
        echo "<!-- Bootstrap JS from CDN -->
\t\t\t\t <script src=\"https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js\" integrity=\"sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz\" crossorigin=\"anonymous\"></script>
\t\t\t";
    }

    public function getTemplateName()
    {
        return "partials/base.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  110 => 32,  105 => 27,  97 => 17,  93 => 15,  90 => 14,  83 => 35,  81 => 32,  78 => 31,  76 => 30,  72 => 28,  70 => 27,  66 => 25,  64 => 24,  59 => 21,  57 => 14,  49 => 10,  42 => 7,  40 => 6,  33 => 1,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Source("<!DOCTYPE html>
<html>
\t<head>
\t\t<meta charset=\"utf-8\"/>
\t\t<title>
\t\t\t{% if page.title %}
\t\t\t\t{{ page.title|e('html') }}
\t\t\t\t|
\t\t\t{% endif %}
\t\t\t{{ site.title|e('html') }}</title>

\t\t<meta http-equiv=\"X-UA-Compatible\" content=\"IE=edge\">
\t\t<meta name=\"viewport\" content=\"width=device-width, initial-scale=1\">
\t\t{% block stylesheets %}
\t\t\t<!-- CSS -->
\t\t\t<link
\t\t\trel=\"stylesheet\" href=\"{{ url('theme://css/style.css') }}\">
\t\t\t<!-- Bootstrap CSS from CDN -->
\t\t\t<link href=\"https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css\" rel=\"stylesheet\" integrity=\"sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH\" crossorigin=\"anonymous\">
\t\t{% endblock %}
\t</head>
\t<body>
\t\t<header>
\t\t\t{% include 'partials/navbar.html.twig' %}
\t\t</header>

\t\t<main class=\"container\"> {% block content %}{% endblock %}
\t\t\t</main>

\t\t\t{% include 'partials/footer.html.twig' %}

\t\t\t{% block javascripts %}<!-- Bootstrap JS from CDN -->
\t\t\t\t <script src=\"https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js\" integrity=\"sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz\" crossorigin=\"anonymous\"></script>
\t\t\t{% endblock %}

\t\t</body>
\t</html>
", "partials/base.html.twig", "/var/www/html/user/themes/product-theme/templates/partials/base.html.twig");
    }
}
