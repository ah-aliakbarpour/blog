<?php
/**
 * @var $this app\core\View
 * @var $blog
 * @var $id
 */


use app\core\form\From;


// Page title
$this->title = 'Edit Blog';

?>

<div class="row">
    <div class="col">
        <h2>Edit Blog</h2>
    </div>
    <div class="col">
        <a class="btn btn-secondary btn-lg float-end" href="/blog" role="button">Back</a>
    </div>
</div>

<?php $form = From::begin('/blog/' . $id . '/edit', 'post') ?>
    <?php echo $form->input($blog, 'title', 'text'); ?>
    <?php echo $form->input($blog, 'author', 'text'); ?>
    <?php echo $form->textArea($blog, 'context'); ?>
    <div class="mb-3 form-group  float-end">
        <button type="submit" class="btn btn-success">Edit</button>
    </div>
<?php From::end() ?>
