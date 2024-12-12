<?php

namespace App\Controllers;

use App\Core\Session;
use App\Core\View;

class AppController
{
    public function index($queryParams)
    {
        if (Session::get('user')) {
            $user = Session::get('user');
            if ($user['role'] == 0) {
                header('Location: /customer');
            } elseif ($user['role'] == 1) {
                header('Location: /worker');
            } elseif ($user['role'] == 2) {
                header('Location: /admin');
            }
        } else {
            header('Location: /auth/login');
        }
    }

    public function cookiePolicy($queryParams)
    {
        View::render([
            'view' => 'Documents/CookiePolicy',
            'title' => 'Cookie Policy',
            'layout' => 'Customer/CustomerLayout',
        ]);
    }

    public function privacyPolicy($queryParams)
    {
        View::render([
            'view' => 'Documents/PrivacyPolicy',
            'title' => 'Privacy Policy',
            'layout' => 'Customer/CustomerLayout',
        ]);
    }

    public function termsConditions($queryParams)
    {
        View::render([
            'view' => 'Documents/TermsConditions',
            'title' => 'Terms and conditions of use',
            'layout' => 'Customer/CustomerLayout',
        ]);
    }
}
