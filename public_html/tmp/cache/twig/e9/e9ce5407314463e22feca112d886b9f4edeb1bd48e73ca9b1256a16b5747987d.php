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

/* component.html */
class __TwigTemplate_d1c8f5088955299c38e91eb1e5e4ad3091c4cfa83f936d6c0719f15470c9bfaf extends \Twig\Template
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
    }

    // line 1
    public function macro_component($__obj__ = null, ...$__varargs__)
    {
        $macros = $this->macros;
        $context = $this->env->mergeGlobals([
            "obj" => $__obj__,
            "varargs" => $__varargs__,
        ]);

        $blocks = [];

        ob_start(function () { return ''; });
        try {
            // line 2
            echo "\t";
            $this->loadTemplate(twig_get_attribute($this->env, $this->source, ($context["obj"] ?? null), "template", [], "method", false, false, false, 2), "component.html", 2)->display(twig_to_array(twig_get_attribute($this->env, $this->source, ($context["obj"] ?? null), "context", [], "method", false, false, false, 2)));

            return ('' === $tmp = ob_get_contents()) ? '' : new Markup($tmp, $this->env->getCharset());
        } finally {
            ob_end_clean();
        }
    }

    public function getTemplateName()
    {
        return "component.html";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  52 => 2,  39 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("", "component.html", "/var/www/html/components/component.html");
    }
}
