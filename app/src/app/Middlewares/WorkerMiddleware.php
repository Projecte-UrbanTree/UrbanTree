<?php

namespace App\Middlewares;

use App\Core\Session;

class WorkerMiddleware implements MiddlewareInterface
{
    public function handle($request, $next)
    {
        if (! Session::get('user')) {
            header('Location: /auth/login');
            exit;
        }

        if (Session::get('user')['role'] !== 1) {
            if (Session::get('user')['role'] == 0) {
                header('Location: /customer');
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
