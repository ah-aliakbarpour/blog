<?php
/**
 * @var $this app\core\View
 * @var $blog
 */


use app\core\form\From;


// Page title
$this->title = 'Create Blog';

?>

<div class="row">
    <div class="col">
        <h2>Create Blog</h2>
    </div>
    <div class="col">
        <a class="btn btn-secondary btn-lg float-end" href="/blog" role="button">Back</a>
    </div>
</div>

<?php $form = From::begin('/blog/create', 'post') ?>
    <?php echo $form->input($blog, 'title', 'text'); ?>
    <?php echo $form->input($blog, 'author', 'text'); ?>
    <?php echo $form->textArea($blog, 'context'); ?>
    <div class="mb-3 form-group">
        <button type="submit" class="btn btn-primary float-end">Create</button>
    </div>
<?php From::end() ?>
