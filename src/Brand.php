<?php
    class Brand
    {
        private $name;
        private $id;


        function __construct($name, $id = null){
            $this->name = $name;
            $this->id = $id;
        }

        function getName(){
            return $this->name;
        }

        function setName($new_name){
            $this->name = $new_name;
        }

        function getId(){
            return $this->id;
        }

        function save(){
            $GLOBALS['DB']->exec("INSERT INTO brands (name) VALUES ('{$this->getName()}');");
            $this->id = $GLOBALS['DB']->lastInsertId();
        }

        function delete(){
            $GLOBALS['DB']->exec("DELETE FROM brands WHERE id = {$this->getId()};");
            $GLOBALS['DB']->exec("DELETE FROM brands_stores WHERE brand_id = {$this->getId()}");
        }

        function update($new_name){
            $GLOBALS['DB']->exec("UPDATE brands SET name = '{$new_name}' WHERE id = {$this->getId()};");
            $this->setName($new_name);
        }

        function addStore($new_store){
            $GLOBALS['DB']->exec("INSERT INTO brands_stores (brand_id, store_id) VALUES ({$this->getId()}, {$new_store->getId()});");
        }

        function getStores(){
            $returned_stores = $GLOBALS['DB']->query("SELECT stores.* FROM brands
                JOIN brands_stores ON (brands.id = brands_stores.brand_id)
                JOIN stores ON (brands_stores.store_id = stores.id)
                WHERE brands.id = {$this->getId()};");

            $stores = array();
            foreach($returned_stores as $store){
                $name = $store['name'];
                $id = $store['id'];
                $new_store = new Store($name, $id);
                array_push($stores, $new_store);
            }
            return $stores;
        }

        static function getAll(){
            $returned_brands = $GLOBALS['DB']->query("SELECT * FROM brands;");
            $brands = array();
            foreach($returned_brands as $brand){
                $name = $brand['name'];
                $id = $brand['id'];
                $new_brand = new Brand($name, $id);

                array_push($brands, $new_brand);
            }
            return $brands;
        }

        static function find($search_id){
            $found_brand = null;
            $brands = Brand::getAll();
            foreach($brands as $brand){
                $brand_id = $brand->getId();
                if ($search_id == $brand_id){
                    $found_brand = $brand;
                }
            }
            return $found_brand;
        }

        static function deleteAll(){
            $GLOBALS['DB']->exec("DELETE FROM brands;");
        }
    }
?>
