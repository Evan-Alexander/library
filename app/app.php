<?php
    date_default_timezone_set('America/Los_Angeles');
    require_once __DIR__."/../vendor/autoload.php";
    require_once __DIR__."/../src/Book.php";
    require_once __DIR__."/../src/Author.php";

    use Symfony\Component\Debug\Debug;
    Debug::enable();

    use Symfony\Component\HttpFoundation\Request;
    Request::enableHttpMethodParameterOverride();

    $app = new Silex\Application();
    $app['debug']=true;

    $server = 'mysql:host=localhost:8889;dbname=library';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    $app->register(new Silex\Provider\TwigServiceProvider(), array(
      'twig.path' => __DIR__.'/../views'
    ));

    $app->get("/", function() use ($app) {
        return $app['twig']->render('index.html.twig', array('books' => Book::getAll(), 'authors' => Author::getAll()));
    });

    $app->post("/", function() use ($app) {
        $book = new Book($_POST['name']);
        $book->save();
        $author = new Author($_POST['author']);
        $author->save();
        $book->addAuthor($author);
        return $app->redirect('/');
    });

    $app->post("/delete_books", function() use ($app) {
      Book::deleteAll();
      Author::deleteAll();
      return $app->redirect('/');
    });

    $app->get("/books/{id}", function($id) use ($app) {
        $book = Book::find($id);
        return $app['twig']->render('book.html.twig', array('book' => $book, 'authors' => $book->getAuthors(), 'all_authors' => Author::getAll()));
    });

    $app->patch("/books/{id}", function($id) use ($app) {
        $book = Book::find($id);
        $book->update($_POST['new-title']);
        return $app['twig']->render('book.html.twig', array('book' => $book, 'authors' => $book->getAuthors(), 'all_authors' => Author::getAll()));
    });

    $app->post("/update/{id}", function($id) use ($app) {
        $new_author = new Author($_POST['add-author']);
        $new_author->save();
        $book = Book::find($id);
        $book->addAuthor($new_author);
        return $app['twig']->render('book.html.twig', array('book' => $book, 'authors' => $book->getAuthors(), 'all_authors' => Author::getAll()));
    });

    $app->get("authors/{id}", function($id) use ($app) {
        $author = Author::find($id);
        return $app['twig']->render('author.html.twig', array('author' => $author, 'books' => $author->getBooks(), 'all_books' => Book::getAll()));
    });

    $app->patch("/authors/{id}", function($id) use ($app) {
        $author = Author::find($id);
        $author->update($_POST['new-author']);
        return $app['twig']->render('author.html.twig', array('author' => $author, 'books' => $author->getBooks(), 'all_bookss' => Book::getAll()));
    });

    $app->post("/update-author/{id}", function($id) use ($app) {
        $new_book = new Book($_POST['add-book']);
        $new_book->save();
        $author = Author::find($id);
        $author->addBook($new_book);
        return $app->redirect('/authors/'. $id);
    });

    return $app;
?>
