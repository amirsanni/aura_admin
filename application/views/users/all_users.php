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
                    <th>Name</th>
                    <th>Username</th>
                    <th>Profession</th>
                    <th>E-mail</th>
                    <th>Phone Number(s)</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($all_users as $get):?>
                    <tr>
                        <th><?=$sn?>.</th>
                        <td>
                            <a class="pointer gumd" id="user-<?=$get->id?>">
                                <?=$get->first_name . " ". $get->last_name?>
                            </a>
                        </td>
                        <td id="uListUsername-<?=$get->id?>"><?=$get->username?></td>
                        <td id="uListProf-<?=$get->id?>"><?=$get->profession?></td>
                        <td><a href="mailto:<?=$get->email?>" id="uListEmail-<?=$get->id?>"><?=$get->email?></a></td>
                        <td id="uListTel-<?=$get->id?>"><?=trim($get->mobile_1 . "&nbsp;&nbsp;". $get->mobile_2)?></td>
                    </tr>
                    <?php $sn++;?>
                <?php endforeach;?>
            </tbody>
        </table>
    </div>
    <?php else:?>
    No registered user
    <?php endif; ?>
</div>
<!-- Pagination -->
<div class="row text-center">
    <?php echo isset($links) ? $links : ""?>
</div>
<!-- Pagination ends -->