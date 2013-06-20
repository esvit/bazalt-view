<?php

namespace Bazalt\View\PHP;

class Engine extends \Bazalt\View\Engine
{
    protected $localeDomain = null;

    protected $options = [];

    protected $twig = null;

    public function __construct($options = [])
    {
        $this->options = $options;
    }

    public function getTwig($folder)
    {
        if ($this->twig === null) {
            $loader = new \Twig_Loader_Filesystem($folder);
            $this->twig = new \Twig_Environment($loader, $this->options);

            if (DEBUG) {
                $this->twig->addExtension(new \Twig_Extension_Debug());
            }
        }
        return $this->twig;
    }

    public static function fetchString($string, $vars = array())
    {
        $loader = new \Twig_Loader_String();
        $twig = new \Twig_Environment($loader, array(
            'debug' => true,
            'auto_reload' => true,
            'cache' => TEMP_DIR . '/templates/Twig'
        ));


        //$vars['bazalt_cms_locale_domain'] = $this->localeDomain;

        return $twig->render($string, $vars);
    }

    public function fetch($folder, $file, View\Scope $view)
    {
        $vars = $view->variables();

        $vars['bazalt_cms_locale_domain'] = $this->localeDomain;

        $twig = $this->getTwig($folder);

        $template = $twig->loadTemplate($file);
        $content = $template->render($vars);
        return $content;
    }

    public function setLocaleDomain($domain)
    {
        $this->localeDomain = $domain;
    }
}