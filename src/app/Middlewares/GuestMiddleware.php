<?php

namespace App\Middlewares;

use App\Core\Session;

class GuestMiddleware implements MiddlewareInterface
{
    public function handle($request, $next)
    {
        if (Session::get('user') && $request['uri'] === '/auth/login') {
            header('Location: /');
            exit;
        }

        return $next($request);
    }
}
