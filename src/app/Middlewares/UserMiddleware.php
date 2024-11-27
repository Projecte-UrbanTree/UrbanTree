<?php

namespace App\Middlewares;

use App\Core\Session;

class UserMiddleware implements MiddlewareInterface
{
    public function handle($request, $next)
    {
        if (!Session::get('user')) {
            header('Location: /login');
            exit;
        }

        if (Session::get('user')['role'] !== 1) {
            header('Location: /admin/dashboard');
            exit;
        }

        return $next($request);
    }
}
