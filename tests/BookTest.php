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

        function test_getBookId()
        {
            $name = "The shadow of the wing";
            $id = 2;
            $new_book = new Book($name, $id);

            $result = $new_book->getBookId();

            $this->assertEquals($id, $result);
        }
    }

?>
