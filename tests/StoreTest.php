<?php
    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

    require_once "src/Store.php";
    require_once "src/Brand.php";

    $server = 'mysql:host=localhost:8889;dbname=shoes_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    class StoreTest extends PHPUnit_Framework_TestCase {

        protected function tearDown(){
            Brand::deleteAll();
            Store::deleteAll();
        }

        function test_getName(){
            $store_name = "Foot Locker";
            $test_store = new Store($store_name);
            $test_store->setName($store_name);

            $result = $test_store->getName();

            $this->assertEquals($store_name, $result);
        }

        function test_getId(){
            $store_name = "Foot Locker";
            $id = 1;
            $test_store = new Store($store_name, $id);

            $result = $test_store->getId();

            $this->assertEquals($id, $result);
        }

        function test_save(){
            $store_name = "Foot Locker";
            $test_store = new Store($store_name);
            $test_store->save();

            $result = Store::getAll();

            $this->assertEquals([$test_store], $result);
        }

        function test_getAll(){
            $store_name = "Foot Locker";
            $test_store = new Store($store_name);
            $test_store->save();

            $store_name2 = "KOHls";
            $test_store2 = new Store($store_name2);
            $test_store2->save();

            $result = Store::getAll();

            $this->assertEquals([$test_store, $test_store2], $result);
        }

        function test_delete(){
            $store_name = "Foot Locker";
            $test_store = new Store($store_name);
            $test_store->save();

            $store_name2 = "KOHls";
            $test_store2 = new Store($store_name2);
            $test_store2->save();

            $test_store->delete();
            $result = Store::getAll();

            $this->assertEquals([$test_store2], $result);
        }

        function test_update(){
            $store_name = "Foot Locker";
            $test_store = new Store($store_name);
            $test_store->save();

            $new_name = "KOHLs";

            $test_store->update($new_name);

            $this->assertEquals($new_name, $test_store->getName());
        }

        function test_addBrand(){
            $store_name = "Foot Locker";
            $test_store = new Store($store_name);
            $test_store->save();

            $brand_name = "Nike";
            $test_brand = new Brand($brand_name);
            $test_brand->save();

            $test_store->addBrand($test_brand);

            $this->assertEquals($test_store->getBrands(), [$test_brand]);
        }

        function test_getBrands(){
            $store_name = "Foot Locker";
            $id = 1;
            $test_store = new Store($store_name, $id);
            $test_store->save();

            $brand_name = "Nike";
            $test_brand = new Brand($brand_name);
            $test_brand->save();

            $brand_name2 = "Adidas";
            $test_brand2 = new Brand($brand_name2);
            $test_brand2->save();

            $test_store->addBrand($test_brand);
            $test_store->addBrand($test_brand2);

            $this->assertEquals($test_store->getBrands(), [$test_brand, $test_brand2]);
        }

        function test_find(){
            $store_name = "Foot Locker";
            $id = 1;
            $test_store = new Store($store_name, $id);
            $test_store->save();

            $store_name2 = "KOHLs";
            $id2 = 2;
            $test_store2 = new Store($store_name2, $id2);
            $test_store2->save();

            $result = Store::find($test_store2->getId());

            $this->assertEquals($test_store2, $result);
        }
    }
?>
