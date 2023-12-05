<?php global $router;
$title = 'Book List'; /* Ustaw tytuł strony */ ?>

<?php ob_start() ?>
    <h1>Book List</h1>
    <ul>
        <?php $books = 0;
        foreach ($books as $book): ?>
            <li>
                <?= $book->getTitle() ?>
                <a href="<?= $router->generatePath('book-details', ['id' => $book->getId()]) ?>">Details</a>
                <a href="<?= $router->generatePath('book-edit', ['id' => $book->getId()]) ?>">Edit</a>
            </li>
        <?php endforeach; ?>
    </ul>
    <a href="<?= $router->generatePath('book-add') ?>">Add Book</a>
<?php $content = ob_get_clean() ?>

<?php include 'base.html.php' ?>