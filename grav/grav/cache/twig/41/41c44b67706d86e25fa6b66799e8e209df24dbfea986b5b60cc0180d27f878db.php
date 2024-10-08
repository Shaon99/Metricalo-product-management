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

/* default.html.twig */
class __TwigTemplate_651cde01ff013fd79db578a3fa5b7e34ff1f2ab01c2505bbc1d43cf8dafdbb7e extends \Twig\Template
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
        // line 2
        echo "<h3 style=\"color:red\">ERROR: <code>";
        echo twig_escape_filter($this->env, ((($this->getAttribute(($context["page"] ?? null), "template", [], "method") . ".") . $this->getAttribute(($context["page"] ?? null), "templateFormat", [], "method")) . ".twig"), "html", null, true);
        echo "</code> template not found for page: <code>";
        echo twig_escape_filter($this->env, $this->getAttribute(($context["page"] ?? null), "route", [], "method"), "html", null, true);
        echo "</code></h3>
<h1>";
        // line 3
        echo twig_escape_filter($this->env, $this->getAttribute(($context["page"] ?? null), "title", [], "method"), "html", null, true);
        echo "</h1>
";
        // line 4
        echo $this->getAttribute(($context["page"] ?? null), "content", [], "method");
        echo "
";
    }

    public function getTemplateName()
    {
        return "default.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  41 => 4,  37 => 3,  30 => 2,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Source("{# Default output if no theme #}
<h3 style=\"color:red\">ERROR: <code>{{ page.template() ~'.'~ page.templateFormat() ~\".twig\" }}</code> template not found for page: <code>{{ page.route() }}</code></h3>
<h1>{{ page.title() }}</h1>
{{ page.content()|raw }}
", "default.html.twig", "/var/www/html/system/templates/default.html.twig");
    }
}
