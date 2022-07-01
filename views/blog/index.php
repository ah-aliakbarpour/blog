<?php
/**
 * @var $blogs
 * @var $allRecords
 * @var $allPages
 * @var $currentPage
 * @var $limit
 * @var $start
 * @var $end
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

        <?php if (!($allRecords <= $limit)): ?>
            <div>
                <p><?php echo "Showing $start - $end of $allRecords results"; ?></p>
            </div>
        <?php endif; ?>
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
                <?php foreach ($blogs as $blog): ?>
                    <tr>
                        <th><?php echo $start++ ?></th>
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

        <?php if (!($allRecords <= $limit)): ?>
            <br>
            <nav aria-label="Page navigation example">
                <ul class="pagination">
                    <li class="page-item <?php if ($currentPage == 1) echo 'disabled'; ?>">
                        <a class="page-link" href="?page=<?php echo $currentPage - 1; ?>" tabindex="-1">Previous</a>
                    </li>

                    <?php
                    for($page = 1; $page <= $allPages; $page++) {
                        echo '<li class="page-item' . ($page == $currentPage ? ' disabled' : '') . '">';
                        echo '<a class="page-link"  href = "?page=' . $page . '">' . $page . ' </a>';
                        echo '</li>';
                    }
                    ?>

                    <li class="page-item <?php if ($currentPage == $allPages) echo 'disabled'; ?>">
                        <a class="page-link" href="?page=<?php echo $currentPage + 1; ?>">Next</a>
                    </li>
                </ul>
            </nav>
        <?php endif; ?>

    <?php endif; ?>
</div>




