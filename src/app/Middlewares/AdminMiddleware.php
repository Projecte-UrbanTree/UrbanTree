<?php

namespace App\Middlewares;

use App\Core\Session;

class AdminMiddleware implements MiddlewareInterface
{
    public function handle($request, $next)
    {
        if (!Session::get('user')) {
            header('Location: /auth/login');
            exit;
        }

        if (Session::get('user')['role'] !== 2) {
            header('Location: /');
            exit;
        }

        return $next($request);
    }
}
