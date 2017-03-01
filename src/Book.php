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

        function save()
        {
            $GLOBALS['DB']->exec("INSERT INTO books(book_name) VALUES ('{$this->getBookName()}');");
            $this->id = $GLOBALS['DB']->lastInsertId();
        }

        static function getAll()
        {
            $returned_books = $GLOBALS['DB']->query("SELECT * FROM books;");

            $books = [];
            foreach($returned_books as $book)
            {
                $name = $book['book_name'];
                $id = $book['id'];
                $new_book = new Book($name, $id);

                array_push($books, $new_book);
            }
            return $books;
        }

        static function deleteAll()
        {
            $GLOBALS['DB']->exec("DELETE FROM books;");
        }
    }

 ?>
