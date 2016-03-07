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
            Store::deleteAll();
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

            $this->assertEquals([$test_brand], $result);
        }

        function test_getAll(){
            $brand_name = "Nike";
            $test_brand = new Brand($brand_name);
            $test_brand->save();

            $brand_name2 = "Adidas";
            $test_brand2 = new Brand($brand_name2);
            $test_brand2->save();

            $result = Brand::getAll();

            $this->assertEquals([$test_brand, $test_brand2], $result);
        }

        function test_delete(){
            $brand_name = "Nike";
            $test_brand = new Brand($brand_name);
            $test_brand->save();

            $brand_name2 = "Adidas";
            $test_brand2 = new Brand($brand_name2);
            $test_brand2->save();

            $test_brand->delete();
            $result = Brand::getAll();

            $this->assertEquals([$test_brand2], $result);
        }

        function test_update(){
            $brand_name = "Nike";
            $test_brand = new Brand($brand_name);
            $test_brand->save();

            $new_name = "Adidas";

            $test_brand->update($new_name);

            $this->assertEquals($new_name, $test_brand->getName());
        }

        function test_addStore(){
            $brand_name = "Nike";
            $test_brand = new Brand($brand_name);
            $test_brand->save();

            $store_name = "Foot Locker";
            $test_store = new Store($store_name);
            $test_store->save();

            $test_brand->addStore($test_store);

            $this->assertEquals($test_brand->getStores(), [$test_store]);
        }

        function test_getStores(){
            $brand_name = "Nike";
            $id = 1;
            $test_brand = new Brand($brand_name, $id);
            $test_brand->save();

            $store_name = "Foot Locker";
            $test_store = new Store($store_name);
            $test_store->save();

            $store_name2 = "KOHLs";
            $test_store2 = new Store($store_name2);
            $test_store2->save();

            $test_brand->addStore($test_store);
            $test_brand->addStore($test_store2);

            $this->assertEquals($test_brand->getStores(), [$test_store, $test_store2]);
        }

        function test_find(){
            $brand_name = "Nike";
            $id = 1;
            $test_brand = new Brand($brand_name, $id);
            $test_brand->save();

            $brand_name2 = "New Balance";
            $id2 = 2;
            $test_brand2 = new Brand($brand_name2, $id2);
            $test_brand2->save();

            $result = Brand::find($test_brand->getId());

            $this->assertEquals($test_brand, $result);
        }
    }
?>
