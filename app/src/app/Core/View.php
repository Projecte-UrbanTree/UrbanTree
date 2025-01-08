<?php

namespace App\Core;

use App\Models\Contract;
use Exception;

class View
{
    public static function render($options = [], $useContracts = true)
    {
        $title = $options['title'] ?? 'Default Title';
        $layout = $options['layout'] ?? 'AdminLayout';
        $view = $options['view'] ?? 'Home';
        $data = $options['data'] ?? [];

        if (!file_exists(__DIR__ . "/../Views/{$view}.php")) {
            throw new Exception("View file not found: {$view}");
        }

        extract($data);
        ob_start();
        require_once __DIR__ . "/../Views/{$view}.php";
        $content = ob_get_clean();

        if ($useContracts) {
            $contracts = Contract::findAll();
        }

        if (file_exists(__DIR__ . "/../Layouts/{$layout}.php")) {
            require_once __DIR__ . "/../Layouts/{$layout}.php";
        } else {
            throw new Exception("Layout file not found: {$layout}");
        }

        if (Session::has('success')) {
            Session::remove('success');
        }

        if (Session::has('error')) {
            Session::remove('error');
        }
    }
}
