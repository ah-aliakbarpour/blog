<?php
/**
* @var $blogs
 */

// Page title
use app\core\form\From;

$this->title = 'Blogs List';

?>



<div class="row">
    <div class="col">
        <h2>Blogs List</h2>
    </div>
    <div class="col">
        <a class="btn btn-primary btn-lg float-end" href="/blog/create" role="button">Create New Blog</a>
    </div>
</div>

<br><br>

<div>
    <?php if (empty($blogs)): ?>
        <center>
            <h3>There isn't any blog!</h3>
        </center>
    <?php else: ?>
        <table class="table  table-hover">
            <thead>
                <tr>
                    <th scope="col"></th>
                    <th scope="col">Title</th>
                    <th scope="col">Author</th>
                    <th scope="col">Context</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($blogs as $index => $blog): ?>
                    <tr>
                        <th><?php echo $index + 1 ?></th>
                        <td><?php echo $blog->title ?></td>
                        <td><?php echo $blog->author ?></td>
                        <td><?php echo strlen($blog->context) > 40 ? substr($blog->context,0,40)."..." : $blog->context; ?></td>
                        <td>
                            <a class="btn btn-primary btn-sm" href="/blog/<?php echo $blog->id ?>" role="button">Details</a>
                            <a class="btn btn-success btn-sm" href="/blog/<?php echo $blog->id ?>/edit" role="button">Edit</a>
                            <?php $form = From::begin('/blog/' . $blog->id . '/destroy', 'post', 'style="display: inline;"') ?>
                                <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                            <?php From::end() ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>




