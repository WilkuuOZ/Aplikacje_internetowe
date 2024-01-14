<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'autoload.php';

$config = new \App\Service\Config();

$templating = new \App\Service\Templating();
$router = new \App\Service\Router();

$action = $_REQUEST['action'] ?? null;
switch ($action) {
    // PostController actions
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
    case 'post-delete':
        if (! $_REQUEST['id']) {
            break;
        }
        $postController = new \App\Controller\PostController();
        $view = $postController->deleteAction($_REQUEST['id'], $router);
        break;

    // GamesController actions
    case 'games-index':
        $gamesController = new \App\Controller\GamesController();
        $view = $gamesController->indexAction($templating, $router);
        break;
    case 'games-create':
        $gamesController = new \App\Controller\GamesController();
        $view = $gamesController->createAction($_REQUEST['game'] ?? null, $templating, $router);
        break;
    case 'games-edit':
        if (!$_REQUEST['id']) {
            break;
        }
        $gamesController = new \App\Controller\GamesController();
        $view = $gamesController->editAction($_REQUEST['id'], $_REQUEST['game'] ?? null, $templating, $router);
        break;
    case 'games-show':
        if (!$_REQUEST['id']) {
            break;
        }
        $gamesController = new \App\Controller\GamesController();
        $view = $gamesController->showAction($_REQUEST['id'], $templating, $router);
        break;
    case 'games-delete':
        if (!$_REQUEST['id']) {
            break;
        }
        $gamesController = new \App\Controller\GamesController();
        $view = $gamesController->deleteAction($_REQUEST['id'], $router);
        break;

    default:
        $view = 'Not found';
        break;
}

if ($view) {
    echo $view;
}
