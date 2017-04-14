<?php

/* @WebProfiler/Collector/router.html.twig */
class __TwigTemplate_52606e65bf38f9b3165838e30d0339bd0eb06c9ef2ff678fdfc88eea97b1c289 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        // line 1
        $this->parent = $this->loadTemplate("@WebProfiler/Profiler/layout.html.twig", "@WebProfiler/Collector/router.html.twig", 1);
        $this->blocks = array(
            'toolbar' => array($this, 'block_toolbar'),
            'menu' => array($this, 'block_menu'),
            'panel' => array($this, 'block_panel'),
        );
    }

    protected function doGetParent(array $context)
    {
        return "@WebProfiler/Profiler/layout.html.twig";
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $__internal_266302ffa6133f76d8a77c617b37148059274d5a8d2b2d7fa201169d17e40576 = $this->env->getExtension("native_profiler");
        $__internal_266302ffa6133f76d8a77c617b37148059274d5a8d2b2d7fa201169d17e40576->enter($__internal_266302ffa6133f76d8a77c617b37148059274d5a8d2b2d7fa201169d17e40576_prof = new Twig_Profiler_Profile($this->getTemplateName(), "template", "@WebProfiler/Collector/router.html.twig"));

        $this->parent->display($context, array_merge($this->blocks, $blocks));
        
        $__internal_266302ffa6133f76d8a77c617b37148059274d5a8d2b2d7fa201169d17e40576->leave($__internal_266302ffa6133f76d8a77c617b37148059274d5a8d2b2d7fa201169d17e40576_prof);

    }

    // line 3
    public function block_toolbar($context, array $blocks = array())
    {
        $__internal_945cd5ad11ff58cd7dc5d697e923d68738a297c5856028d8988f4e8535aa6b93 = $this->env->getExtension("native_profiler");
        $__internal_945cd5ad11ff58cd7dc5d697e923d68738a297c5856028d8988f4e8535aa6b93->enter($__internal_945cd5ad11ff58cd7dc5d697e923d68738a297c5856028d8988f4e8535aa6b93_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "toolbar"));

        
        $__internal_945cd5ad11ff58cd7dc5d697e923d68738a297c5856028d8988f4e8535aa6b93->leave($__internal_945cd5ad11ff58cd7dc5d697e923d68738a297c5856028d8988f4e8535aa6b93_prof);

    }

    // line 5
    public function block_menu($context, array $blocks = array())
    {
        $__internal_5b76ecffc824bd059dfbb54e55d27f168f4db7f8f346eddc7107ab05af3a01da = $this->env->getExtension("native_profiler");
        $__internal_5b76ecffc824bd059dfbb54e55d27f168f4db7f8f346eddc7107ab05af3a01da->enter($__internal_5b76ecffc824bd059dfbb54e55d27f168f4db7f8f346eddc7107ab05af3a01da_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "menu"));

        // line 6
        echo "<span class=\"label\">
    <span class=\"icon\">";
        // line 7
        echo twig_include($this->env, $context, "@WebProfiler/Icon/router.svg");
        echo "</span>
    <strong>Routing</strong>
</span>
";
        
        $__internal_5b76ecffc824bd059dfbb54e55d27f168f4db7f8f346eddc7107ab05af3a01da->leave($__internal_5b76ecffc824bd059dfbb54e55d27f168f4db7f8f346eddc7107ab05af3a01da_prof);

    }

    // line 12
    public function block_panel($context, array $blocks = array())
    {
        $__internal_a6615a2dcd25942798efa435101e8d3cbab51183df42290b58c72c48120f94a5 = $this->env->getExtension("native_profiler");
        $__internal_a6615a2dcd25942798efa435101e8d3cbab51183df42290b58c72c48120f94a5->enter($__internal_a6615a2dcd25942798efa435101e8d3cbab51183df42290b58c72c48120f94a5_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "panel"));

        // line 13
        echo "    ";
        echo $this->env->getExtension('http_kernel')->renderFragment($this->env->getExtension('routing')->getPath("_profiler_router", array("token" => (isset($context["token"]) ? $context["token"] : $this->getContext($context, "token")))));
        echo "
";
        
        $__internal_a6615a2dcd25942798efa435101e8d3cbab51183df42290b58c72c48120f94a5->leave($__internal_a6615a2dcd25942798efa435101e8d3cbab51183df42290b58c72c48120f94a5_prof);

    }

    public function getTemplateName()
    {
        return "@WebProfiler/Collector/router.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  73 => 13,  67 => 12,  56 => 7,  53 => 6,  47 => 5,  36 => 3,  11 => 1,);
    }
}
/* {% extends '@WebProfiler/Profiler/layout.html.twig' %}*/
/* */
/* {% block toolbar %}{% endblock %}*/
/* */
/* {% block menu %}*/
/* <span class="label">*/
/*     <span class="icon">{{ include('@WebProfiler/Icon/router.svg') }}</span>*/
/*     <strong>Routing</strong>*/
/* </span>*/
/* {% endblock %}*/
/* */
/* {% block panel %}*/
/*     {{ render(path('_profiler_router', { token: token })) }}*/
/* {% endblock %}*/
/* */
