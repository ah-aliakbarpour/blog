<?php
/**
 * @var $paginate
 * @var $search
 */

// Page title
use app\core\form\From;

$this->title = 'Blogs List';

$blogs = $paginate['records']

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

<?php $form = From::begin('/blog', 'get') ?><div class="row">
    <div class="col-md-10">
        <?php echo $form->input($search, 'search', 'text'); ?>
    </div>
    <div class="col-md-2">
        <br>
        <input type="submit" value="Search" class="btn btn-primary btn-block">
    </div>
</div>
<?php From::end() ?>

<br>

<div>
    <?php if (empty($blogs)): ?>
        <center>
            <h3>There isn't any blog!</h3>
        </center>
    <?php else: ?>

        <?php if (!($paginate['allRecords'] <= $paginate['limit'])): ?>
            <div>
                <p><?php echo "Showing".$paginate['start']." - ".$paginate['end']." of ".$paginate['allRecords']." results"; ?></p>
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
                        <th><?php echo $paginate['start']++ ?></th>
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

        <?php if (!($paginate['allRecords'] <= $paginate['limit'])): ?>
            <?php
                $searchLink = "&search=$search->seearch";
            ?>
            <br>
            <nav aria-label="Page navigation example">
                <ul class="pagination">
                    <li class="page-item <?php if ($paginate['currentPage'] == 1) echo $paginate['disabled']; ?>">
                        <a class="page-link" href="?page=<?php echo $paginate['currentPage'] - 1 . $searchLink; ?>" tabindex="-1">Previous</a>
                    </li>

                    <?php
                    for($page = 1; $page <= $paginate['allPages']; $page++) {
                        echo '<li class="page-item' . ($page == $paginate['currentPage'] ? ' disabled' : '') . '">';
                        echo '<a class="page-link"  href = "?page=' . $page . $searchLink . '">' . $page . ' </a>';
                        echo '</li>';
                    }
                    ?>

                    <li class="page-item <?php if ($paginate['currentPage'] == $paginate['allPages']) echo 'disabled'; ?>">
                        <a class="page-link" href="?page=<?php echo $paginate['currentPage'] + 1 . $searchLink; ?>">Next</a>
                    </li>
                </ul>
            </nav>
        <?php endif; ?>

    <?php endif; ?>
</div>




