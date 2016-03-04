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

        static function deleteAll(){
            $GLOBALS['DB']->exec("DELETE FROM brands;");
        }
    }
?>
