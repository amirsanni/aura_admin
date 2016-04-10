<?php
defined('BASEPATH') OR exit('Get out');
?>

<?php echo isset($range) && !empty($range) ? "Showing ".$range : ""?>
<div class="panel panel-primary">
    <div class="panel-heading">Blogs</div>
    <?php if($all_blogs):?>
    <div class="table table-responsive">
        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>SN</th>
                    <th>Title</th>
                    <th>Body</th>
                    <th>Author</th>
                    <th>Uploaded By</th>
                    <th>Date Created</th>
                    <th>Published</th>
                    <th>Edit</th>
                    <th>Last Edited</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($all_blogs as $get):?>
                    <tr>
                        <th><?=$sn?>.</th>
                        <td>
                            <a class="pointer gumd" id="blog-<?=$get->id?>">
                                <?=$get->title?>
                            </a>
                        </td>
                        <td id="uListBody-<?=$get->id?>"><?= word_limiter($get->body, 20);?></td>
                        <td id="uListAuthor-<?=$get->id?>"><?=$get->author?></td>
                        <td id="uListUploaded_by-<?=$get->id?>"><?=$get->username?></td>
                        <td><?=date('jS M, Y h:ma', strtotime($get->date_created))?></td>
                        <td>
                            <a class="pointer suspendBlog" id="b-<?=$get->id?>">
                                <i class="<?= $get->published == 1 ? 'fa fa-toggle-on' : 'fa fa-toggle-off'?>"></i>
                            </a>
                        </td>
                        <td><span id="blog-<?=$get->id?>" class="fa fa-pencil pointer edBlog"></span></td>
                        <td><?= $get->last_edited ? date('jS M, Y h:ma', strtotime($get->last_edited)) : "---"?></td>
                    </tr>
                    <?php $sn++;?>
                <?php endforeach;?>
            </tbody>
        </table>
    </div>
    <?php else:?>
    No blog available
    <?php endif; ?>
</div>
<!-- Pagination -->
<div class="row text-center">
    <?php echo isset($links) ? $links : ""?>
</div>
<!-- Pagination ends -->
<?php
function LimitCharacter($data,$limit = 20)
{
    if (strlen($data) > $limit)
    {
        $data = substr($data, 0, strrpos(substr($data, 0, $limit), ' ')) . '...';
        return $data;
    }
    else
    {
        return $data;
    }
}
?>