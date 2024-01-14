<?php
/** @var \App\Model\Games $game */
/** @var \App\Service\Router $router */

$title = "{$game->getSubject()} ({$game->getId()})";
$bodyClass = 'show';

ob_start(); ?>
    <h1><?= $game->getSubject() ?></h1>
    <article>
        <?= $game->getContent(); ?>
    </article>

    <ul class="action-list">
        <li><a href="<?= $router->generatePath('games-index') ?>">Back to list</a></li>
        <li><a href="<?= $router->generatePath('games-edit', ['id' => $game->getId()]) ?>">Edit</a></li>
    </ul>
<?php $main = ob_get_clean();

include __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'base.html.php';
