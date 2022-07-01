<?php
/**
 * @var $blog
 * @var $id
 */

// Page title
use app\core\form\From;

$this->title = 'Blog Details';

?>



<div class="row">
    <div class="col">
        <h2>Blog Details</h2>
    </div>
    <div class="col">
        <a class="btn btn-secondary btn-lg float-end" href="/blog" role="button">Back</a>
    </div>
</div>

<br><br>

<div class="row">
    <div class="col">
        <table class="table  table-hover">
            <tbody>
            <tr>
                <th>Title:</th>
                <td><?php echo $blog->title ?></td>
            </tr>
            <tr>
                <th>Author:</th>
                <td><?php echo $blog->author ?></td>
            </tr>
            <tr>
                <th>Created At:</th>
                <td><?php echo $blog->created_at ?></td>
            </tr>
            <tr>
                <th>Updated At:</th>
                <td><?php echo $blog->updated_at ?></td>
            </tr>
            </tbody>
        </table>
    </div>
    <div class="col">
        <table class="table  table-hover">
            <tbody>
            <tr>
                <th>context:</th>
                <td><?php echo $blog->context ?></td>
            </tr>
            </tbody>
        </table>
    </div>
</div>
<div class="row">
    <div class="col">
        <span class=" float-end">
            <a class="btn btn-success btn-sm" href="/blog/<?php echo $id ?>/edit" role="button">Edit</a>
            <?php $form = From::begin('/blog/' . $id . '/destroy', 'post', 'style="display: inline;"') ?>
            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
            <?php From::end() ?>
        </span>
    </div>
</div>





