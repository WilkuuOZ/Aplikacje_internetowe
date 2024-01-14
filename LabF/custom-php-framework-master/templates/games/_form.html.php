<?php
/** @var \App\Model\Games|null $game */
?>

<div class="form-group">
    <label for="subject">Subject</label>
    <input type="text" id="subject" name="game[subject]" value="<?= $game ? $game->getSubject() : '' ?>">
</div>

<div class="form-group">
    <label for="content">Content</label>
    <textarea id="content" name="game[content]"><?= $game ? $game->getContent() : '' ?></textarea>
</div>

<div class="form-group">
    <label></label>
    <input type="submit" value="Submit">
</div>
