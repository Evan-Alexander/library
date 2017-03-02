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
    return $app;
?>
