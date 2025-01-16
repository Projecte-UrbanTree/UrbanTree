<?php

namespace App\Middlewares;

use App\Core\Session;

class CustomerMiddleware implements MiddlewareInterface
{
    public function handle($request, $next)
    {
        if (! Session::get('user')) {
            header('Location: /auth/login');
            exit;
        }

        if (Session::get('user')['role'] !== 0) {
            if (Session::get('user')['role'] == 1) {
                header('Location: /worker');
                exit;
            }
            if (Session::get('user')['role'] == 2) {
                header('Location: /admin');
                exit;
            }
        }

        return $next($request);
    }
}
