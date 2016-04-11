<?php
defined('BASEPATH') OR exit('Get out');
?>

<?php echo isset($range) && !empty($range) ? "Showing ".$range : ""?>
<div class="panel panel-primary">
    <div class="panel-heading">Projects</div>
    <?php if($project_list):?>
    <div class="table table-responsive">
        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>SN</th>
                    <th>Title</th>
                    <th>Description</th>
                    <th>Category</th>
                    <th>Creator</th>
                    <th>Date Created</th>
                    <th>Published</th>
                    <th>Delete</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($project_list as $get):?>
                    <tr>
                        <th class='projSn'><?=$sn?>.</th>
                        <td><a href="projects/<?=$get->id?>"><?=$get->title?></a></td>
                        <td><?=word_limiter($get->description, 25)?></td>
                        <td><?=$get->category?></td>
                        <td><a href="mailto:<?=$get->creator_email?>"><?=$get->username?></a></td>
                        <td><?=date('jS M, Y h:ia', strtotime($get->date_created))?></td>
                        <td>
                            <a class="pointer pubProj" id="proj-<?=$get->id?>">
                                <i class="<?= $get->published == 1 ? 'fa fa-toggle-on' : 'fa fa-toggle-off'?>"></i>
                            </a>
                        </td>
                        <td><button class="btn btn-danger btn-sm delProj"><i class="fa fa-trash"></i> Delete</button></td>
                        <input type='hidden' value='<?=$get->id?>'>
                    </tr>
                    <?php $sn++;?>
                <?php endforeach;?>
            </tbody>
        </table>
    </div>
    <?php else:?>
    No Projects Found
    <?php endif; ?>
</div>
<!-- Pagination -->
<div class="row text-center">
    <?php echo isset($links) ? $links : ""?>
</div>
<!-- Pagination ends -->