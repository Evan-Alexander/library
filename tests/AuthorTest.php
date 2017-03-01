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
        function tearDown()
        {
            Author::deleteAll();
        }

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

        function test_save()
        {
            $author_name = "Hemingway";
            $id = null;
            $new_author_name = new Author($author_name, $id);
            $new_author_name->save();

            $result = Author::getAll();

            $this->assertEquals([$new_author_name], $result);
        }

        function test_deleteAll()
        {
            $author_name = "Hemingway";
            $id = null;
            $new_author_name = new Author($author_name, $id);
            $new_author_name->save();

            $author2 = "McDougall";
            $id = null;
            $new_author2 = new Author($author2, $id);
            $new_author2->save();

            Author::deleteAll();

            $result = Author::getAll();

            $this->assertEquals([], $result);
        }
    }
?>
