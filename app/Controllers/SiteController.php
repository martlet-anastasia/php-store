<?php

    namespace App\Controllers;

    use App\Models\Product;
    use mysqli;

    class SiteController
    {
        public function index()
        {
            $product = new Product();
            $product->name = 'new prodicut';
            $product->description = 'kjdsdjsdkjs';
            $product->save();

            die();
            render('main.php');
        }

        public function notFound()
        {
            render('404.php');
        }

    }