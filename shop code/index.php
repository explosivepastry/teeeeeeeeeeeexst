<?php 

spl_autoload_register(function ($name){
    if (preg_match('/Controller$/', $name))
    {
        $name = "controllers/${name}";
    }
    else if (preg_match('/Model$/', $name))
    {
        $name = "models/${name}";
    }
    include_once "${name}.php";
});

$router = new Router();

// Landing URL
$router->new('GET', '/', 'HomeController@index');
$router->new('GET', '/about', 'HomeController@about');
$router->new('GET', '/faq', 'HomeController@faq');
$router->new('GET', '/contact', 'HomeController@contact');

// Authentication URLs
$router->new('GET', '/login', 'AuthController@login');
$router->new('GET', '/register','AuthController@register');
$router->new('GET', '/forgot-password', 'AuthController@forgot_password');
$router->new('POST', '/api/login', 'AuthController@authenticate');
$router->new('POST', '/api/register', 'AuthController@create_account');
$router->new('POST', '/api/forgot-password', 'AuthController@post_forgot_password');
$router->new('GET', '/logout', 'AuthController@logout');
$router->new('POST', '/api/tokens', 'AuthController@token_endpoint');

// User URLs
$router->new('GET', '/dashboard', 'UserController@index');
$router->new('GET', '/profile', 'UserController@profile');
$router->new('GET', '/products', 'UserController@products');
$router->new('GET', '/products/buy', 'UserController@purchase_products');
$router->new('GET', '/products/orders', 'UserController@orders');
$router->new('POST', '/api/products/buy', 'UserController@purchase_products_post');
$router->new('GET', '/projects', 'UserController@projects');
$router->new('GET', '/projects/add', 'UserController@project_add');
$router->new('POST', '/api/projects/add', 'UserController@project_add_post');
$router->new('GET', '/projects/edit/{param}', 'UserController@project_edit');
$router->new('POST', '/api/projects/edit', 'UserController@project_edit_post');
$router->new('POST', '/api/settings/edit', 'UserController@edit_settings');
$router->new('GET', '/calendar', 'UserController@calendar');

// Admin URLs
$router->new('POST', '/api/admin', 'AdminController@admin_endpoint');
$router->new('GET', '/api/admin/list_products', 'AdminController@list_products');
$router->new('POST', '/api/admin/add_product', 'AdminController@add_product');
$router->new('POST', '/api/admin/healthcheck', 'AdminController@health_check');
$router->new('POST', '/api/admin/list_members', 'AdminController@list_members');

$response = $router->match();

die($response);