<?php

use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Extension\SandboxExtension;
use Twig\Markup;
use Twig\Sandbox\SecurityError;
use Twig\Sandbox\SecurityNotAllowedTagError;
use Twig\Sandbox\SecurityNotAllowedFilterError;
use Twig\Sandbox\SecurityNotAllowedFunctionError;
use Twig\Source;
use Twig\Template;

/* navigation/navigation.html */
class __TwigTemplate_5aff048559e6621da2b047a22bf10a36273db88ff4d6790c499dd55e7a69869e extends \Twig\Template
{
    private $source;
    private $macros = [];

    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        $this->parent = false;

        $this->blocks = [
        ];
    }

    protected function doDisplay(array $context, array $blocks = [])
    {
        $macros = $this->macros;
        // line 1
        echo "<nav class=\"navbar navbar-expand-lg navbar-dark bg-dark\">
\t<a class=\"navbar-brand\" href=\"#\">";
        // line 2
        echo twig_escape_filter($this->env, call_user_func_array($this->env->getFilter('translated')->getCallable(), ["navigation_brand"]), "html", null, true);
        echo "</a>
\t<button class=\"navbar-toggler\" type=\"button\" data-toggle=\"collapse\" data-target=\"#navbarSupportedContent\" aria-controls=\"navbarSupportedContent\" aria-expanded=\"false\" aria-label=\"Toggle navigation\">
\t\t<span class=\"navbar-toggler-icon\"></span>
\t</button>

\t<div class=\"collapse navbar-collapse\" id=\"navbarSupportedContent\">
\t\t<ul class=\"navbar-nav mr-auto\">
\t\t\t";
        // line 9
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(($context["items"] ?? null));
        foreach ($context['_seq'] as $context["_key"] => $context["item"]) {
            // line 10
            echo "\t\t\t\t";
            $context["activeClass"] = ((twig_get_attribute($this->env, $this->source, $context["item"], "active", [], "method", false, false, false, 10)) ? ("active") : (""));
            // line 11
            echo "\t\t\t\t<li class=\"nav-item ";
            echo twig_escape_filter($this->env, ($context["activeClass"] ?? null), "html", null, true);
            echo "\">
\t\t\t\t\t<a class=\"nav-link\" href=\"";
            // line 12
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["item"], "href", [], "method", false, false, false, 12), "html", null, true);
            echo "\">";
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["item"], "label", [], "method", false, false, false, 12), "html", null, true);
            echo "</a>
\t\t\t\t</li>
\t\t\t";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['item'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 15
        echo "\t\t</ul>
\t\t<ul class=\"navbar-nav\">
\t\t\t<li class=\"nav-item dropdown\">
\t\t\t\t<a class=\"nav-link dropdown-toggle\" href=\"#\" id=\"navbarDropdownMenuLink\" role=\"button\" data-toggle=\"dropdown\" aria-haspopup=\"true\" aria-expanded=\"false\">
\t\t\t\t\t";
        // line 19
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, ($context["user"] ?? null), "displayName", [], "method", false, false, false, 19), "html", null, true);
        echo "
\t\t\t\t</a>
\t\t\t\t<div class=\"dropdown-menu dropdown-menu-right\" aria-labelledby=\"navbarDropdownMenuLink\">
\t\t\t\t\t<a class=\"dropdown-item\" href=\"#\">";
        // line 22
        echo twig_escape_filter($this->env, call_user_func_array($this->env->getFilter('translated')->getCallable(), ["navigation_logout"]), "html", null, true);
        echo "</a>
\t\t\t\t</div>
\t\t\t</li>
\t\t</ul>
\t</div>
</nav>";
    }

    public function getTemplateName()
    {
        return "navigation/navigation.html";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  85 => 22,  79 => 19,  73 => 15,  62 => 12,  57 => 11,  54 => 10,  50 => 9,  40 => 2,  37 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("", "navigation/navigation.html", "/var/www/html/components/navigation/navigation.html");
    }
}
