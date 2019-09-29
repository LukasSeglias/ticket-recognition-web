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

/* login/login_form.html */
class __TwigTemplate_e41020e0f2024da04dca1eebb4658cea061a5a86beebb45f76c6c7f7a1ff8b94 extends \Twig\Template
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
        echo "<div class=\"row d-flex justify-content-center\">
\t<div class=\"col-12 col-sm-12 col-md-6 col-lg-6\">
\t\t<div class=\"card my-3\">
\t\t\t<div class=\"card-header\">
\t\t\t\t";
        // line 5
        echo twig_escape_filter($this->env, call_user_func_array($this->env->getFilter('translated')->getCallable(), ["login_title"]), "html", null, true);
        echo "
\t\t\t</div>
\t\t\t<div class=\"card-body\">
\t\t\t\t<form>
\t\t\t\t\t<div class=\"form-group\">
\t\t\t\t\t\t<label for=\"email\">";
        // line 10
        echo twig_escape_filter($this->env, call_user_func_array($this->env->getFilter('translated')->getCallable(), ["login_email_label"]), "html", null, true);
        echo "</label>
\t\t\t\t\t\t";
        // line 11
        $context["emailValidClass"] = ((twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, ($context["email"] ?? null), "validationResult", [], "method", false, false, false, 11), "isValid", [], "method", false, false, false, 11)) ? ("is-valid") : (""));
        // line 12
        echo "\t\t\t\t\t\t";
        $context["emailInvalidClass"] = ((twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, ($context["email"] ?? null), "validationResult", [], "method", false, false, false, 12), "isInvalid", [], "method", false, false, false, 12)) ? ("is-invalid") : (""));
        // line 13
        echo "\t\t\t\t\t\t<input type=\"email\" class=\"form-control ";
        echo twig_escape_filter($this->env, ($context["emailValidClass"] ?? null), "html", null, true);
        echo " ";
        echo twig_escape_filter($this->env, ($context["emailInvalidClass"] ?? null), "html", null, true);
        echo "\" id=\"email\" placeholder=\"";
        echo twig_escape_filter($this->env, call_user_func_array($this->env->getFilter('translated')->getCallable(), ["login_email_placeholder"]), "html", null, true);
        echo "\">
\t\t\t\t\t</div>
\t\t\t\t\t<div class=\"form-group\">
\t\t\t\t\t\t<label for=\"password\">";
        // line 16
        echo twig_escape_filter($this->env, call_user_func_array($this->env->getFilter('translated')->getCallable(), ["login_password_label"]), "html", null, true);
        echo "</label>
\t\t\t\t\t\t";
        // line 17
        $context["passwordValidClass"] = ((twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, ($context["password"] ?? null), "validationResult", [], "method", false, false, false, 17), "isValid", [], "method", false, false, false, 17)) ? ("is-valid") : (""));
        // line 18
        echo "\t\t\t\t\t\t";
        $context["passwordInvalidClass"] = ((twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, ($context["password"] ?? null), "validationResult", [], "method", false, false, false, 18), "isInvalid", [], "method", false, false, false, 18)) ? ("is-invalid") : (""));
        // line 19
        echo "\t\t\t\t\t\t<input type=\"password\" class=\"form-control ";
        echo twig_escape_filter($this->env, ($context["passwordValidClass"] ?? null), "html", null, true);
        echo " ";
        echo twig_escape_filter($this->env, ($context["passwordInvalidClass"] ?? null), "html", null, true);
        echo "\" id=\"password\" placeholder=\"";
        echo twig_escape_filter($this->env, call_user_func_array($this->env->getFilter('translated')->getCallable(), ["login_password_placeholder"]), "html", null, true);
        echo "\">
\t\t\t\t\t</div>
\t\t\t\t\t<button type=\"submit\" class=\"btn btn-primary\">";
        // line 21
        echo twig_escape_filter($this->env, call_user_func_array($this->env->getFilter('translated')->getCallable(), ["login_submit"]), "html", null, true);
        echo "</button>
\t\t\t\t\t<button type=\"reset\" class=\"btn\">";
        // line 22
        echo twig_escape_filter($this->env, call_user_func_array($this->env->getFilter('translated')->getCallable(), ["login_reset"]), "html", null, true);
        echo "</button>
\t\t\t\t</form>
\t\t\t</div>
\t\t</div>
\t</div>
</div>";
    }

    public function getTemplateName()
    {
        return "login/login_form.html";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  94 => 22,  90 => 21,  80 => 19,  77 => 18,  75 => 17,  71 => 16,  60 => 13,  57 => 12,  55 => 11,  51 => 10,  43 => 5,  37 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("", "login/login_form.html", "/var/www/html/components/login/login_form.html");
    }
}
