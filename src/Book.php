<?php
    Class Book
    {
        private $name;
        private $id;

        function __construct($name, $id = null)
        {
            $this->name = $name;
            $this->id =  $id;
        }

        function getBookName()
        {
            return $this->name;
        }

        function setBookName($new_book)
        {
            $this->name = (string) $new_book;
        }

        function getBookId()
        {
            return $this->id;
        }
    }

 ?>
