<?php
/** @var $router \App\Service\Router */
?>

<?php $this->extend('base.html.php') ?>

<?php $this->startBlock('content') ?>
<h1>Add Book</h1>
<form action="<?= $router->generatePath('add-book-submit') ?>" method="post">
    <label for="title">Title:</label>
    <input type="text" id="title" name="title" required>

    <label for="author">Author:</label>
    <input type="text" id="author" name="author" required>

    <label for="isbn">ISBN:</label>
    <input type="text" id="isbn" name="isbn" required>

    <button type="submit">Add Book</button>
</form>
<?php $this->endBlock() ?>->endBlock() ?>