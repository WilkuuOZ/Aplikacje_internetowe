<?php
/** @var $router \App\Service\Router */
/** @var $book \App\Model\Book */

?>
<ul>
    <li><a href="<?= $router->generatePath('') ?>">Home</a></li>
    <li><a href="<?= $router->generatePath('post-index') ?>">Posts</a></li>

    <li><a href="<?= $router->generatePath('book-list') ?>">Books</a></li>

</ul>
<?php
