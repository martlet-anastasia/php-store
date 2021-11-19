<?php

    namespace App\Controllers;

    use App\Models\Product;

    class CatalogController
    {
        public function index() {
            render('store.php');
        }

        public function showProduct() {
            $id = (int) $_GET['id'];
            $product = Product::findById($id);
            $allProducts = Product::selectAll();
            render('product.php', [
                'product' => $product,
                'productList' => $allProducts
            ]);
        }

        public function showForm() {
            render('addProductForm.php');
        }

        public function saveProduct() {
            $path = $_SERVER['DOCUMENT_ROOT'].'/'.$_FILES['img']['name'];
            move_uploaded_file($_FILES['img']['tmp_name'], $path);
        }
    }