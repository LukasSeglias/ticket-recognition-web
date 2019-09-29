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

/* ticket/ticket_form.html */
class __TwigTemplate_65fc222baf43468311307f1e8258e8cb5a97fe38335646ae9306f9d97b1873e3 extends \Twig\Template
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
        echo "<div class=\"card my-3\">
\t<div class=\"card-header d-flex justify-content-between align-items-center\">
\t\t";
        // line 3
        echo twig_escape_filter($this->env, call_user_func_array($this->env->getFilter('translated')->getCallable(), ["ticket_title", twig_get_attribute($this->env, $this->source, ($context["ticket"] ?? null), "nr", [], "any", false, false, false, 3)]), "html", null, true);
        echo "
\t\t<div>
\t\t\t";
        // line 5
        if (twig_get_attribute($this->env, $this->source, ($context["mode"] ?? null), "isView", [], "method", false, false, false, 5)) {
            // line 6
            echo "\t\t\t<!-- TODO: implement delete -->
\t\t\t<button type=\"button\" class=\"btn btn-danger\">
\t\t\t\t<span class=\"oi oi-trash\"></span>
\t\t\t</button>
\t\t\t<!-- TODO: implement edit -->
\t\t\t<button type=\"button\" class=\"btn btn-warning ml-2\">
\t\t\t\t<span class=\"oi oi-pencil\"></span>
\t\t\t</button>
\t\t\t";
        }
        // line 15
        echo "\t\t\t";
        if ( !twig_get_attribute($this->env, $this->source, ($context["mode"] ?? null), "isView", [], "method", false, false, false, 15)) {
            // line 16
            echo "\t\t\t<!-- TODO: implement cancel -->
\t\t\t<button type=\"button\" class=\"btn btn-warning\">
\t\t\t\t<span class=\"oi oi-ban\"></span>
\t\t\t</button>
\t\t\t<!-- TODO: implement save -->
\t\t\t<button type=\"button\" class=\"btn btn-success ml-2\">
\t\t\t\t<span class=\"oi oi-check\"></span>
\t\t\t</button>
\t\t\t";
        }
        // line 25
        echo "\t\t</div>
\t</div>
\t<div class=\"card-body\">
\t\t<form>
\t\t\t<div class=\"form-row\">
\t\t\t\t<div class=\"form-group col-12 col-sm-6\">
\t\t\t\t\t<label for=\"touroperator\">";
        // line 31
        echo twig_escape_filter($this->env, call_user_func_array($this->env->getFilter('translated')->getCallable(), ["ticket_touroperator_label"]), "html", null, true);
        echo "</label>
\t\t\t\t\t<input type=\"text\" required ";
        // line 32
        echo ((twig_get_attribute($this->env, $this->source, ($context["mode"] ?? null), "isView", [], "method", false, false, false, 32)) ? ("readonly") : (""));
        echo " class=\"";
        echo ((twig_get_attribute($this->env, $this->source, ($context["mode"] ?? null), "isView", [], "method", false, false, false, 32)) ? ("form-control-plaintext") : ("form-control"));
        echo "\" id=\"touroperator\" placeholder=\"";
        echo twig_escape_filter($this->env, call_user_func_array($this->env->getFilter('translated')->getCallable(), ["ticket_touroperator_placeholder"]), "html", null, true);
        echo "\" value=\"";
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, ($context["ticket"] ?? null), "touroperator", [], "method", false, false, false, 32), "html", null, true);
        echo "\">
\t\t\t\t</div>
\t\t\t\t<div class=\"form-group col-12 col-sm-6\">
\t\t\t\t\t<label for=\"tourcode\">";
        // line 35
        echo twig_escape_filter($this->env, call_user_func_array($this->env->getFilter('translated')->getCallable(), ["ticket_tourcode_label"]), "html", null, true);
        echo "</label>
\t\t\t\t\t<input type=\"text\" required ";
        // line 36
        echo ((twig_get_attribute($this->env, $this->source, ($context["mode"] ?? null), "isView", [], "method", false, false, false, 36)) ? ("readonly") : (""));
        echo " class=\"";
        echo ((twig_get_attribute($this->env, $this->source, ($context["mode"] ?? null), "isView", [], "method", false, false, false, 36)) ? ("form-control-plaintext") : ("form-control"));
        echo "\" id=\"tourcode\" placeholder=\"";
        echo twig_escape_filter($this->env, call_user_func_array($this->env->getFilter('translated')->getCallable(), ["ticket_tourcode_placeholder"]), "html", null, true);
        echo "\" value=\"";
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, ($context["ticket"] ?? null), "tourcode", [], "method", false, false, false, 36), "html", null, true);
        echo "\">
\t\t\t\t</div>
\t\t\t\t<div class=\"form-group col-12 col-sm-6\">
\t\t\t\t\t<label for=\"date\">";
        // line 39
        echo twig_escape_filter($this->env, call_user_func_array($this->env->getFilter('translated')->getCallable(), ["ticket_date_label"]), "html", null, true);
        echo "</label>
\t\t\t\t\t<input type=\"date\" required ";
        // line 40
        echo ((twig_get_attribute($this->env, $this->source, ($context["mode"] ?? null), "isView", [], "method", false, false, false, 40)) ? ("readonly") : (""));
        echo " class=\"";
        echo ((twig_get_attribute($this->env, $this->source, ($context["mode"] ?? null), "isView", [], "method", false, false, false, 40)) ? ("form-control-plaintext") : ("form-control"));
        echo "\" id=\"date\" placeholder=\"";
        echo twig_escape_filter($this->env, call_user_func_array($this->env->getFilter('translated')->getCallable(), ["ticket_date_placeholder"]), "html", null, true);
        echo "\" value=\"";
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, ($context["ticket"] ?? null), "date", [], "method", false, false, false, 40), "html", null, true);
        echo "\">
\t\t\t\t</div>
\t\t\t</div>
\t\t</form>
\t</div>
</div>";
    }

    public function getTemplateName()
    {
        return "ticket/ticket_form.html";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  117 => 40,  113 => 39,  101 => 36,  97 => 35,  85 => 32,  81 => 31,  73 => 25,  62 => 16,  59 => 15,  48 => 6,  46 => 5,  41 => 3,  37 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("", "ticket/ticket_form.html", "/var/www/html/components/ticket/ticket_form.html");
    }
}
