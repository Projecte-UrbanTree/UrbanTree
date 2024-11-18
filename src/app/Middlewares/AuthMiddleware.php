<?php

namespace App\Middlewares;

use App\Core\Session;

class AuthMiddleware implements MiddlewareInterface
{
    public function handle($request, $next)
    {
        if (!Session::get('user')) {
            header('Location: /auth/login');
            exit;
        }

        return $next($request);
    }
}
