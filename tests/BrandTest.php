<?php
    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

    require_once "src/Brand.php";
    require_once "src/Store.php";

    $server = 'mysql:host=localhost:8889;dbname=shoes_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    class BrandTest extends PHPUnit_Framework_TestCase {

        protected function tearDown(){
            Brand::deleteAll();
            // Store::deleteAll();
        }

        function test_getName(){
            $brand_name = "Nike";
            $test_brand = new Brand($brand_name);
            $test_brand->setName($brand_name);

            $result = $test_brand->getName();

            $this->assertEquals($brand_name, $result);
        }

        function test_getId(){
            $brand_name = "Nike";
            $id = 1;
            $test_brand = new Brand($brand_name, $id);
            $test_brand->setName($brand_name);

            $result = $test_brand->getId();

            $this->assertEquals($id, $result);
        }

        function test_save(){
            $brand_name = "Nike";
            $test_brand = new Brand($brand_name);
            $test_brand->save();

            $result = Brand::getAll();

            $this->assertEquals([$test_brand], $result)
        }
    }
?>
