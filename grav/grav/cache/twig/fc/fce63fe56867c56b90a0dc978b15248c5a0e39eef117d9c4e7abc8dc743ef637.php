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

/* partials/navbar.html.twig */
class __TwigTemplate_ececf925640da6e21c926d9c1fdd61714cc8a46920a2e945803d4285df2f7675 extends \Twig\Template
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
        echo "<!-- Navbar -->
<nav class=\"navbar navbar-expand-lg navbar-dark bg-primary\">
\t<div class=\"container\">
\t\t<a class=\"navbar-brand\" href=\"";
        // line 4
        echo twig_escape_filter($this->env, $this->env->getExtension('Grav\Common\Twig\Extension\GravExtension')->urlFunc("/"), "html", null, true);
        echo "\">
\t\t\t<span class=\"navbar-brand-text fs-3\">Metricalo</span>
\t\t</a>
\t</div>
</nav>
";
    }

    public function getTemplateName()
    {
        return "partials/navbar.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  35 => 4,  30 => 1,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Source("<!-- Navbar -->
<nav class=\"navbar navbar-expand-lg navbar-dark bg-primary\">
\t<div class=\"container\">
\t\t<a class=\"navbar-brand\" href=\"{{ url('/') }}\">
\t\t\t<span class=\"navbar-brand-text fs-3\">Metricalo</span>
\t\t</a>
\t</div>
</nav>
", "partials/navbar.html.twig", "/var/www/html/user/themes/product-theme/templates/partials/navbar.html.twig");
    }
}
