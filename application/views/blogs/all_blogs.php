<?php
defined('BASEPATH') OR exit('Get out');
?>

<?php echo isset($range) && !empty($range) ? "Showing ".$range : ""?>
<div class="panel panel-primary">
    <div class="panel-heading">Users</div>
    <?php if($all_users):?>
    <div class="table table-responsive">
        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>SN</th>
                    <th>Title</th>
                    <th>Author</th>
                    <th>Body</th>
                    <th>Uploaded By</th>
                    <th>Date Created</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($all_users as $get):?>
                    <tr>
                        <th><?=$sn?>.</th>
                        <td>
                            <a class="pointer gumd" id="blog-<?=$get->id?>">
                                <?=$get->title?>
                            </a>
                        </td>
                        <td id="uListTitle-<?=$get->id?>"><?=$get->title?></td>
                        <td id="uListBody-<?=$get->id?>"><?=$get->body?></td>
                        <td id="uListAuthor-<?=$get->id?>"><?=$get->author?></td>
                        <td id="uListCreated-<?=$get->id?>"><?=trim($get->date_created)?></td>
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