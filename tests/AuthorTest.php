<?php
    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

    require_once "src/Author.php";
    // require_once "src/Book.php";

    $server = 'mysql:host=localhost:8889;dbname=library_test';
    $username = 'root';
    $password = 'root';

    $DB = new PDO($server, $username, $password);

    class AuthorTest extends PHPUnit_Framework_TestCase
    {
        function test_getAuthorName()
        {
            $author_name = "Fred";
            $new_author = new Author($author_name);

            $result = $new_author->getAuthorName();

            $this->assertEquals($author_name, $result);
        }

        function test_setAuthorName()
        {
            $author_name = "Fred";
            $new_author = new Author($author_name);

            $new_author_name = "Sam";

            $new_author->setAuthorName($new_author_name);
            $result = $new_author->getAuthorName();

            $this->assertEquals($new_author_name, $result);
        }

        function test_getId()
        {
            $author_name = "Fred";
            $id = null;
            $new_author = new Author($author_name, $id);

            $result = $new_author->getId();

            $this->assertEquals(null, $result);
        }
    }
?>
