<?php
    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

    require_once "src/Author.php";
    require_once "src/Book.php";

    $server = 'mysql:host=localhost:8889;dbname=library_test';
    $username = 'root';
    $password = 'root';

    $DB = new PDO($server, $username, $password);

    class BookTest extends PHPUnit_Framework_TestCase
    {
        function tearDown()
        {
            Book::deleteAll();
        }

        function test_getBookName()
        {
            $name = "The Lord Of The Rings";
            $new_book = new Book($name);

            $result = $new_book->getBookName();

            $this->assertEquals($name, $result);
        }

        function test_setBookName()
        {
            $name = "The shadow of the wing";
            $new_book = new Book($name);

            $name2 = "The shadow of the tree";

            $new_book->setBookName($name2);
            $result = $new_book->getBookName();

            $this->assertEquals($name2, $result);
        }

        // CRUD
        function test_getBookId()
        {
            $name = "The shadow of the wing";
            $id = 2;
            $new_book = new Book($name, $id);

            $result = $new_book->getBookId();

            $this->assertEquals($id, $result);
        }

        function test_save()
        {
            $name = "Runnin away form Epicodus";
            $id = null;
            $new_book = new Book($name, $id);
            $new_book->save();

            $result = Book::getAll();

            $this->assertEquals([$new_book], $result);
        }

        function test_deleteAll()
        {
            $name = "PHP for single grandmas with dependent kids";
            $id = null;
            $new_book = new Book($name, $id);
            $new_book->save();

            $name2 = "PHP for dummies";
            $id2 = null;
            $new_book2 = new Book($name2, $id2);
            $new_book2->save();

            Book::deleteAll();
            $result = Book::getAll();
            $this->assertEquals([], $result);


        }
    }

?>
