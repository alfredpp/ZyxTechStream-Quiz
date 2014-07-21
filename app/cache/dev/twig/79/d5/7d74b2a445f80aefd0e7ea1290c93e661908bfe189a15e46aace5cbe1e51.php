<?php

/* ZyxwareQuizBundle:Quiz:result.html.twig */
class __TwigTemplate_79d57d74b2a445f80aefd0e7ea1290c93e661908bfe189a15e46aace5cbe1e51 extends Twig_Template
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
  <body>
    <h1>
      Hi ";
        // line 4
        echo twig_escape_filter($this->env, (isset($context["user"]) ? $context["user"] : $this->getContext($context, "user")), "html", null, true);
        echo ", Your score is ";
        echo twig_escape_filter($this->env, (isset($context["score"]) ? $context["score"] : $this->getContext($context, "score")), "html", null, true);
        echo ".
    </h1>
  </body>
</html>
";
    }

    public function getTemplateName()
    {
        return "ZyxwareQuizBundle:Quiz:result.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  24 => 4,  19 => 1,);
    }
}
