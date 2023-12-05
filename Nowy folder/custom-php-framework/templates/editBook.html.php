<?php
/** @var $router \App\Service\Router */
/** @var $book \App\Model\Book */
?>

<?php $this->extend('base.html.php') ?>

<?php $this->startBlock('content') ?>
<h1>Edit Book</h1>
<form action="<?= $router->generatePath('edit-book-submit', ['id' => $book->getId()]) ?>" method="post">
    <label for="title">Title:</label>
    <input type="text" id="title" name="title" value="<?= $book->getTitle() ?>" required>

    <label for="author">Author:</label>
    <input type="text" id="author" name="author" value="<?= $book->getAuthor() ?>" required>

    <label for="isbn">ISBN:</label>
    <input type="text" id="isbn" name="isbn" value="<?= $book->getIsbn() ?>" required>

    <button type="submit">Update Book</button>
</form>
<?php $this->endBlock() ?>ndBlock() ?>