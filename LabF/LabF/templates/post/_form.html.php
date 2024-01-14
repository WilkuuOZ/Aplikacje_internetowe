<?php
    /** @var $post ?\App\Model\Post */
?>

<div class="form-group">
    <label for="year">Mark</label>
    <input type="text" id="subject" name="post[subject]" value="<?= $post ? $post->getSubject() : '' ?>">
</div>

<div class="form-group">
    <label for="model">Model</label>
    <input type="text" id="model" name="post[model]" value="<?= $post ? $post->getModel() : '' ?>">
</div>

<div class="form-group">
    <label for="year">Year</label>
    <input type="number" id="year" name="post[year]" value="<?= $post ? $post->getYear() : '' ?>">
</div>

<div class="form-group">
    <label for="color">Color</label>
    <input type="text" id="color" name="post[color]" value="<?= $post ? $post->getColor() : '' ?>">
</div>

<div class="form-group">
    <label for="engine">Engine</label>
    <input type="text" id="engine" name="post[engine]" value="<?= $post ? $post->getEngine() : '' ?>">
</div>

<div class="form-group">
    <label for="content">Content</label>
    <textarea id="content" name="post[content]"><?= $post? $post->getContent() : '' ?></textarea>
</div>

<div class="form-group">
    <label></label>
    <input type="submit" value="Submit">
</div>
