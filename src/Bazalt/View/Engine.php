<?php

namespace Bazalt\View;

class Engine
{
    /**
     * Функція яка опрацьовує шаблон
     *
     * @param string $folder Папка, де лежить шаблон
     * @param string $file   Файл, який треба опрацювати
     * @param Scope  $view
     * @return mixed
     */
    public function fetch($folder, $file, \Bazalt\View $view)
    {
        return file_get_contents($folder . DIRECTORY_SEPARATOR . $file);
    }
}