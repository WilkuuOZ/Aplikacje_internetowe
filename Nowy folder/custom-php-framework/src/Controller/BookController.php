<?php
namespace App\Controller;

use App\Model\Book;
use App\Service\Router;
use App\Service\Templating;

class BookController
{
    private $router;
    private $templating;

    public function __construct(Router $router)
    {
        $this->router = $router;
        $this->templating = new Templating();
    }

    public function bookList()
    {
        $books = Book::findAll();
        return $this->render('bookList.html.php', ['router' => $this->router, 'books' => $books]);
    }

    public function addBook()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $title = $_POST['title'];
            $author = $_POST['author'];
            $isbn = $_POST['isbn'];

            $book = new Book();
            $book->setTitle($title);
            $book->setAuthor($author);
            $book->setIsbn($isbn);

            $book->save();


            $this->router->redirect($this->router->generatePath('book-list'));
        }

        return $this->render('addBook.html.php');
    }

    public function editBook($id)
    {
        $book = Book::find($id);

        if (!$book) {

            $this->router->redirect($this->router->generatePath('book-list'));
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $title = $_POST['title'];
            $author = $_POST['author'];
            $isbn = $_POST['isbn'];

            $book->setTitle($title);
            $book->setAuthor($author);
            $book->setIsbn($isbn);

            $book->save();


            $this->router->redirect($this->router->generatePath('book-list'));
        }

        return $this->render('editBook.html.php', ['book' => $book]);
    }

    public function bookDetails($id)
    {
        $book = Book::find($id);

        if (!$book) {

            $this->router->redirect($this->router->generatePath('book-list'));
        }

        return $this->render('bookDetails.html.php', ['book' => $book]);
    }

    private function render($view, $data = [])
    {
        $templatePath = __DIR__ . '/../../templates/' . $view;

        if (!file_exists($templatePath)) {
            throw new \Exception("Template file not found: $view");
        }

        ob_start();
        extract($data);
        include $templatePath;
        return ob_get_clean();
    }
}