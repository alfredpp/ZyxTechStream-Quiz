<?php

/* ZyxwareQuizBundle:Quiz:user.html.twig */
class __TwigTemplate_b535487c2052d98b220d15c587b192b464c6eb7fc9c31a49db9ef741bf5c974d extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 1
        echo "<html>
  <head>
  <title>User Registration</title>
  </head>
  <body>
    <h1>
      ";
        // line 7
        echo         $this->env->getExtension('form')->renderer->renderBlock((isset($context["text"]) ? $context["text"] : $this->getContext($context, "text")), 'form');
        echo "
      ";
        // line 8
        echo twig_escape_filter($this->env, (isset($context["message"]) ? $context["message"] : $this->getContext($context, "message")), "html", null, true);
        echo "
    </h1>
  </body>
</html>
";
    }

    public function getTemplateName()
    {
        return "ZyxwareQuizBundle:Quiz:user.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  31 => 8,  27 => 7,  19 => 1,);
    }
}
