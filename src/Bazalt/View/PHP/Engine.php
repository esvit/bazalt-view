<?php

namespace Bazalt\View\PHP;

class Engine extends \Bazalt\View\Engine
{
    public function fetch($folder, $file, \Bazalt\View $view)
    {
        $vars = $view->variables();

        extract($vars);
        ob_start();

        $errorLevel = error_reporting();
        error_reporting($errorLevel & ~E_NOTICE);

        include $folder . DIRECTORY_SEPARATOR . $file;
        $content = ob_get_contents();
        ob_end_clean();

        error_reporting($errorLevel);

        return $content;
    }
}