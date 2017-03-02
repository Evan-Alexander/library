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

        function test_find()
        {
            $author_name = "King";
            $id = null;
            $new_author = new Author($author_name, $id);
            $new_author->save();

            $author_name2 = "Kong";
            $id2 = 1;
            $new_author2 = new Author($author_name2, $id2);
            $new_author2->save();

            $result = Author::find($new_author2->getId());

            $this->assertEquals($new_author2, $result);
        }

        function test_update()
        {
            $author_name = "King";
            $id = null;
            $new_author = new Author($author_name, $id);
            $new_author->save();
            $new_author_name = "Stephen";


            $new_author->update($new_author_name);
            $result = $new_author->getAuthorName();

            $this->assertEquals($new_author_name, $result);
        }

        function test_delete()
        {
            $author_name = "King";
            $id = null;
            $new_author = new Author($author_name, $id);
            $new_author->save();

            $author_name2 = "Bacon";
            $id2 = null;
            $new_author2 = new Author($author_name2, $id2);
            $new_author2->save();

            $new_author->delete();

            $result = Author::getAll();

            $this->assertEquals([$new_author2], $result);
        }

        function test_addBook()
        {
            $author_name = "King";
            $id = null;
            $new_author = new Author($author_name, $id);
            $new_author->save();

            $book_name = "Life of Pi";
            $id = null;
            $new_book = new Book($book_name, $id);
            $new_book->save();

            $new_author->addBook($new_book);

            $this->assertEquals($new_author->getBooks(), [$new_book]);
        }

        function test_getBooks()
        {
          $author_name = "King";
          $id = null;
          $new_author = new Author($author_name, $id);
          $new_author->save();

          $book_name = "Life of Pi";
          $id = null;
          $new_book = new Book($book_name, $id);
          $new_book->save();

          $book_name2 = "The Alchemist";
          $id2 = null;
          $new_book2 = new Book($book_name2, $id2);
          $new_book2->save();

          $new_author->addBook($new_book);
          $new_author->addBook($new_book2);

          $this->assertEquals($new_author->getBooks(), [$new_book, $new_book2]);
        }
    }
?>
