<?php

class HomeController
{
    public function index($router)
    {
        return $router->view('index');
    }

    public function about($router)
    {
        return $router->view('about');
    }

    public function faq($router)
    {
        return $router->view('faq');
    }

    public function contact($router)
    {
        return $router->view('contact');
    }
}