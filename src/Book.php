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

        static function find($search_id)
        {
             $books = Book::getAll();
             $returned_book = null;
             foreach($books as $book){
                 $book_id = $book->getBookId();
                 if($book_id == $search_id){
                     $returned_book = $book;
                 }
             }
             return $returned_book;
        }

        function update($new_name)
        {
            $GLOBALS['DB']->exec("UPDATE books SET book_name = '{$new_name}' WHERE id = {$this->getBookId()}");
            $this->setBookName($new_name);
        }

        function delete()
        {
            $GLOBALS['DB']->exec("DELETE FROM books WHERE id = {$this->getBookId()}");
        }

        function addAuthor($author)
        {
            $GLOBALS['DB']->exec("INSERT INTO authors_books (author_id, book_id) VALUES ({$author->getId()}, {$this->getBookId()})");
        }

        function getAuthors()
        {
            $query = $GLOBALS['DB']->query("SELECT author_id FROM authors_books WHERE book_id = {$this->getBookId()};");
            $author_ids = $query->fetchAll(PDO::FETCH_ASSOC);

            $authors = [];
            foreach($author_ids as $id){
                $author_id = $id['author_id'];
                $result = $GLOBALS['DB']->query("SELECT * FROM authors WHERE id = {$author_id};");
                $returned_author = $result->fetchAll(PDO::FETCH_ASSOC);

                $name = $returned_author[0]['author_name'];
                $id = $returned_author[0]['id'];
                $new_author = new Author($name, $id);
                array_push($authors, $new_author);
            }
            return $authors;
        }
    }

 ?>
