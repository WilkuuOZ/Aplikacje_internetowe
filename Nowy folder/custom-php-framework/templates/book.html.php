<?php
/** @var $router \App\Service\Router */
/** @var $book \App\Model\Book */

?>

<?php $this->extend('base.html.php') ?>

<?php $this->startBlock('content') ?>
    <h1><?= $book->getTitle() ?></h1>
    <p>Author: <?= $book->getAuthor() ?></p>
    <p>ISBN: <?= $book->getIsbn() ?></p>
<?php $this->endBlock() ?>