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
    }
?>
