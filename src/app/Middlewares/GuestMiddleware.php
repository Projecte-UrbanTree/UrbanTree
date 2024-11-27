<?php

namespace App\Middlewares;

use App\Core\Session;

class GuestMiddleware implements MiddlewareInterface
{
    public function handle($request, $next)
    {
        if (Session::get('user')) {
            $user = Session::get('user');
            switch ($user['role']) {
                case 1:
                    header('Location: /admin/dashboard');
                    break;
                case 2:
                    header('Location: /');
                    break;
            }
            exit;
        }

        return $next($request);
    }
}
