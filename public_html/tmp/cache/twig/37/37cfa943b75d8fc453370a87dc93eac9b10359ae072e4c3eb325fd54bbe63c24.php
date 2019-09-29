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

/* ticket/ticketposition_list.html */
class __TwigTemplate_d4f1de657aa2d5ce19043fbaac8f69674d759d46b5d6a233c2a5939c5d33efb2 extends \Twig\Template
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
        echo "<div class=\"card mb-3\">
\t<div class=\"card-header d-flex justify-content-between align-items-center\">
\t\t";
        // line 3
        echo twig_escape_filter($this->env, call_user_func_array($this->env->getFilter('translated')->getCallable(), ["ticketpositions_title"]), "html", null, true);
        echo "
\t\t";
        // line 4
        if ( !twig_get_attribute($this->env, $this->source, ($context["mode"] ?? null), "isView", [], "method", false, false, false, 4)) {
            // line 5
            echo "\t\t<!-- TODO: implement add -->
\t\t<button type=\"button\" class=\"btn btn-primary\">
\t\t\t<span class=\"oi oi-plus\"></span>
\t\t</button>
\t\t";
        }
        // line 10
        echo "\t</div>
\t
\t<ul class=\"list-group list-group-flush\">
\t\t";
        // line 13
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(twig_get_attribute($this->env, $this->source, ($context["ticket"] ?? null), "positions", [], "method", false, false, false, 13));
        foreach ($context['_seq'] as $context["_key"] => $context["position"]) {
            // line 14
            echo "\t\t\t<!-- TODO: set correct href --> 
\t\t\t<a href=\"#\" class=\"list-group-item list-group-item-action d-flex justify-content-between align-items-center\">
\t\t\t\t";
            // line 16
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["position"], "nr", [], "any", false, false, false, 16), "html", null, true);
            echo " - ";
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["position"], "title", [], "any", false, false, false, 16), "html", null, true);
            echo "
\t\t\t\t";
            // line 17
            if ( !twig_get_attribute($this->env, $this->source, ($context["mode"] ?? null), "isView", [], "method", false, false, false, 17)) {
                // line 18
                echo "\t\t\t\t<!-- TODO: implement remove -->
\t\t\t\t<span class=\"btn btn-xs btn-danger\">
\t\t\t\t\t<span class=\"oi oi-trash\"></span>
\t\t\t\t</span>
\t\t\t\t";
            }
            // line 23
            echo "\t\t\t</a>
\t\t";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['position'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 25
        echo "\t</ul>
</div>";
    }

    public function getTemplateName()
    {
        return "ticket/ticketposition_list.html";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  89 => 25,  82 => 23,  75 => 18,  73 => 17,  67 => 16,  63 => 14,  59 => 13,  54 => 10,  47 => 5,  45 => 4,  41 => 3,  37 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("", "ticket/ticketposition_list.html", "/var/www/html/components/ticket/ticketposition_list.html");
    }
}
