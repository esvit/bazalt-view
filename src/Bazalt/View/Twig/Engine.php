<?php

namespace Bazalt\View\Twig;

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

            if (isset($this->options['debug']) && $this->options['debug']) {
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

        return $twig->render($string, $vars);
    }

    public function fetch($folder, $file, \Bazalt\View $view)
    {
        $vars = $view->variables();

        $twig = $this->getTwig($folder);

        $template = $twig->loadTemplate($file);
        $content = $template->render($vars);
        return $content;
    }
}