<?php
/**
 * @var $this app\core\View
 * @var $model
 */


use app\core\form\From;


// Page title
$this->title = 'Create Blog';

?>



<h2>Create Blog</h2>

<?php $form = From::begin('/blog/create', 'post') ?>
    <?php echo $form->input($model, 'title', 'text'); ?>
    <?php echo $form->input($model, 'author', 'text'); ?>
    <?php echo $form->textArea($model, 'context'); ?>
    <div class="mb-3 form-group">
        <button type="submit" class="btn btn-primary">Submit</button>
    </div>
<?php From::end() ?>
