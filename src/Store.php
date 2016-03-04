<?php
    class Store{
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
            $GLOBALS['DB']->exec("INSERT INTO stores (name) VALUES ('{$this->getName()}');");
            $this->id = $GLOBALS['DB']->lastInsertId();
        }
        function delete(){
            $GLOBALS['DB']->exec("DELETE FROM stores WHERE id = {$this->getId()};");
        }

        static function getAll(){
            $stores = array();
            $returned_stores = $GLOBALS['DB']->query("SELECT * FROM stores;");
            foreach($returned_stores as $store){
                $name = $store['name'];
                $id = $store['id'];
                $new_store = new Store($name, $id);

                array_push($stores, $new_store);
            }
            return $stores;
        }

        static function deleteAll(){
            $GLOBALS['DB']->exec("DELETE FROM stores;");
        }
    }
?>
