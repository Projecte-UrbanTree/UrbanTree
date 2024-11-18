<?php

namespace App\Core;

class View
{
    public static function render($options = [])
    {
        $title = $options['title'] ?? 'Default Title';
        $layout = $options['layout'] ?? 'MainLayout';
        $view = $options['view'] ?? 'Home';
        $data = $options['data'] ?? [];

        if (! file_exists(__DIR__."/../Views/{$view}.php")) {
            throw new \Exception("View file not found: {$view}");
        }

        extract($data);
        ob_start();
        require_once __DIR__."/../Views/{$view}.php";
        $content = ob_get_clean();

        if (file_exists(__DIR__."/../Layouts/{$layout}.php")) {
            require_once __DIR__."/../Layouts/{$layout}.php";
        } else {
            throw new \Exception("Layout file not found: {$layout}");
        }
    }
}
