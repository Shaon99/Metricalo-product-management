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
class __TwigTemplate_0700cbbf5f7f728366f88d651cec1ca932d6a47b11e4167218a05cb716723e7c extends \Twig\Template
{
    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = [
            'head' => [$this, 'block_head'],
            'content' => [$this, 'block_content'],
            'js' => [$this, 'block_js'],
        ];
    }

    protected function doDisplay(array $context, array $blocks = [])
    {
        // line 1
        echo "<!DOCTYPE html>
<html lang=\"en\">
<head>
  <meta charset=\"UTF-8\">
  <meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\">
  <meta name=\"description\" content=\"";
        // line 6
        echo twig_escape_filter($this->env, $this->getAttribute(($context["site"] ?? null), "description", []), "html", null, true);
        echo "\">
  <title>";
        // line 7
        echo twig_escape_filter($this->env, $this->getAttribute(($context["page"] ?? null), "title", []), "html", null, true);
        echo " - ";
        echo twig_escape_filter($this->env, $this->getAttribute(($context["site"] ?? null), "title", []), "html", null, true);
        echo "</title>

  ";
        // line 10
        echo "  <link rel=\"stylesheet\" href=\"";
        echo twig_escape_filter($this->env, ($context["theme_url"] ?? null), "html", null, true);
        echo "/css/styles.css\">

  ";
        // line 13
        echo "  ";
        $this->displayBlock('head', $context, $blocks);
        // line 14
        echo "</head>
<body>
  <header>
    <div class=\"container\">
      <h1><a href=\"";
        // line 18
        echo twig_escape_filter($this->env, ($context["base_url"] ?? null), "html", null, true);
        echo "\">";
        echo twig_escape_filter($this->env, $this->getAttribute(($context["site"] ?? null), "title", []), "html", null, true);
        echo "</a></h1>
      <nav>
        <ul>
          ";
        // line 22
        echo "          ";
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable($this->getAttribute($this->getAttribute(($context["page"] ?? null), "header", []), "menu", []));
        foreach ($context['_seq'] as $context["_key"] => $context["item"]) {
            // line 23
            echo "            <li><a href=\"";
            echo twig_escape_filter($this->env, $this->getAttribute($context["item"], "url", []), "html", null, true);
            echo "\">";
            echo twig_escape_filter($this->env, $this->getAttribute($context["item"], "title", []), "html", null, true);
            echo "</a></li>
          ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['item'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 25
        echo "        </ul>
      </nav>
    </div>
  </header>

  <main>
    <div class=\"container\">
      ";
        // line 32
        $this->displayBlock('content', $context, $blocks);
        // line 36
        echo "    </div>
  </main>

  <footer>
    <div class=\"container\">
      <p>&copy; ";
        // line 41
        echo twig_escape_filter($this->env, twig_date_format_filter($this->env, "now", "Y"), "html", null, true);
        echo " ";
        echo twig_escape_filter($this->env, $this->getAttribute(($context["site"] ?? null), "title", []), "html", null, true);
        echo ". All rights reserved.</p>
    </div>
  </footer>

  ";
        // line 46
        echo "  <script src=\"";
        echo twig_escape_filter($this->env, ($context["theme_url"] ?? null), "html", null, true);
        echo "/js/scripts.js\"></script>
  
  ";
        // line 48
        $this->displayBlock('js', $context, $blocks);
        // line 49
        echo "</body>
</html>
";
    }

    // line 13
    public function block_head($context, array $blocks = [])
    {
    }

    // line 32
    public function block_content($context, array $blocks = [])
    {
        // line 33
        echo "        ";
        // line 34
        echo "        ";
        echo twig_escape_filter($this->env, $this->getAttribute(($context["page"] ?? null), "content", []), "html", null, true);
        echo "
      ";
    }

    // line 48
    public function block_js($context, array $blocks = [])
    {
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
        return array (  148 => 48,  141 => 34,  139 => 33,  136 => 32,  131 => 13,  125 => 49,  123 => 48,  117 => 46,  108 => 41,  101 => 36,  99 => 32,  90 => 25,  79 => 23,  74 => 22,  66 => 18,  60 => 14,  57 => 13,  51 => 10,  44 => 7,  40 => 6,  33 => 1,);
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
<html lang=\"en\">
<head>
  <meta charset=\"UTF-8\">
  <meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\">
  <meta name=\"description\" content=\"{{ site.description }}\">
  <title>{{ page.title }} - {{ site.title }}</title>

  {# Include Stylesheets #}
  <link rel=\"stylesheet\" href=\"{{ theme_url }}/css/styles.css\">

  {# Add any other head elements, such as meta tags or favicon links here #}
  {% block head %}{% endblock %}
</head>
<body>
  <header>
    <div class=\"container\">
      <h1><a href=\"{{ base_url }}\">{{ site.title }}</a></h1>
      <nav>
        <ul>
          {# Navigation links #}
          {% for item in page.header.menu %}
            <li><a href=\"{{ item.url }}\">{{ item.title }}</a></li>
          {% endfor %}
        </ul>
      </nav>
    </div>
  </header>

  <main>
    <div class=\"container\">
      {% block content %}
        {# Default content goes here #}
        {{ page.content }}
      {% endblock %}
    </div>
  </main>

  <footer>
    <div class=\"container\">
      <p>&copy; {{ \"now\"|date(\"Y\") }} {{ site.title }}. All rights reserved.</p>
    </div>
  </footer>

  {# Include JavaScript Files #}
  <script src=\"{{ theme_url }}/js/scripts.js\"></script>
  
  {% block js %}{% endblock %}
</body>
</html>
", "partials/base.html.twig", "/var/www/html/user/themes/product-show-theme/templates/partials/base.html.twig");
    }
}
