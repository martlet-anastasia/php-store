<?php

    namespace App\Controllers;

    use App\Models\Product;
    define("MB", 1048576);

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

        public function showMultiForm() {
            render('addProductMultiForm.php');
        }

        public function getFileInfo($index, $value) {

            if($value == 'type') {
                $fileInfo = mime_content_type($_FILES['img']['tmp_name'][$index]);
            } else {
                $fileInfo = $_FILES['img'][$value][$index];
            }
            $fileInfo = explode('/', $fileInfo);

            return $fileInfo[0];
        }

        public function uniqueFileName($name) {
            $existFiles = scandir($_SERVER['DOCUMENT_ROOT'].'/downloads/');
            $i = 0;

            $info = pathinfo($name);
            $ext = $info['extension'];
            $filename = $info['filename'];

            while(in_array($name, $existFiles)) {
                $name = $filename . '_' . $i . '.' . $ext;
                $i = $i + 1;
            }
            return $name;
        }

        function snackCaseToCamelCase($name) {
            $updName = ucwords($name, '_');
            $updName = str_replace('_', '', $updName);

            return lcfirst($updName);
        }

        public function saveProduct() {
            $allowedType = 'image'; // NULL to upload all
            $allowedSize = 1*MB; // -1 to upload all
            $errors = [];
            $files = $_FILES['img'];

            for($i = 1; $i <= count($files['name']); $i++) {
                $index = $i - 1;

                $fileType = $this->getFileInfo($index, 'type');
                $fileSize = (int) $this->getFileInfo($index, 'size');
                $fileName = $this->getFileInfo($index, 'name');
                $fileTmp = $this->getFileInfo($index, 'tmp_name');

                if(is_null($allowedType) || $fileType == $allowedType) {
                    if($allowedSize == -1 || $fileSize < $allowedSize) {
                        // snack case to camel case
                        if(str_contains($fileName, '_')) {
                            $fileName = $this->snackCaseToCamelCase($fileName);
                        }
                        // generate unique file name if needed
                        $fileName = $this->uniqueFileName($fileName);
                        $path = $_SERVER['DOCUMENT_ROOT'].'/downloads/'.$fileName;
                        move_uploaded_file($fileTmp, $path);
                    } else {
                        $errors[] = "Error: File <i>" . $fileName . "</i> was not uploaded. Max file size is <i>" . $allowedSize . "</i> \n";
                    }
                } else {
                    $errors[] = "Error: File <i>" . $fileName . "</i> was not uploaded. Only files of type <i>" . $allowedType . "</i> are supported " . "\n";
                }
            }

            render('saveProduct.php', [
                    'errors' => $errors,
                ]);
        }


    }