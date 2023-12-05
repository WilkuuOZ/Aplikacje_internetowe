<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'autoload.php';

$config = new \App\Service\Config();

$templating = new \App\Service\Templating();
$router = new \App\Service\Router();

$action = $_REQUEST['action'] ?? null;
switch ($action) {
    case 'post-index':
    case null:
        $postController = new \App\Controller\PostController();
        $view = $postController->indexAction($templating, $router);
        break;
    case 'post-create':
        $postController = new \App\Controller\PostController();
        $view = $postController->createAction($_REQUEST['post'] ?? null, $templating, $router);
        break;
    case 'post-edit':
        if (! $_REQUEST['id']) {
            break;
        }
        $postController = new \App\Controller\PostController();
        $view = $postController->editAction($_REQUEST['id'], $_REQUEST['post'] ?? null, $templating, $router);
        break;
    case 'post-show':
        if (! $_REQUEST['id']) {
            break;
        }
        $postController = new \App\Controller\PostController();
        $view = $postController->showAction($_REQUEST['id'], $templating, $router);
        break;
    case 'info':
        $infoController = new \App\Controller\InfoController();
        $view = $infoController->infoAction();
        break;
    case 'book-list':
        $bookController = new \App\Controller\BookController($router);
        $view = $bookController->bookList();
        break;
    case 'add-book':
        $bookController = new \App\Controller\BookController($router);
        $view = $bookController->addBook();
        break;
    case 'edit-book':
        if (!isset($_REQUEST['id'])) {
            break;
        }
        $bookController = new \App\Controller\BookController($router);
        $view = $bookController->editBook($_REQUEST['id']);
        break;
    case 'book-details':
        if (!isset($_REQUEST['id'])) {
            break;
        }
        $bookController = new \App\Controller\BookController($router);
        $view = $bookController->bookDetails($_REQUEST['id']);
        break;
    default:
        $view = 'Not found';
        break;
}

if ($view) {
    echo $view;
}