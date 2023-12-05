<?php $title = 'Book Details';  ?>

<?php ob_start() ?>
    <h1>Book Details</h1>
    <ul>
        <li><strong>Title:</strong> <?= $book->getTitle() ?></li>
        <li><strong>Author:</strong> <?= $book->getAuthor() ?></li>
        <li><strong>ISBN:</strong> <?= $book->getIsbn() ?></li>
    </ul>
<?php $content = ob_get_clean() ?>

<?php include 'base.html.php' ?>