<?php
defined('BASEPATH') OR exit('');
?>
<div class="pwell userDetail">
    <button class="close" id="cud">&times;</button>
    <table class="table table-bordered table-responsive">
        <h4 class="text-center text-uppercase" id="userDetName"></h4>
        <span class="hidden" id="curDisplayedUserId"></span>
        <tbody>
            <tr>
                <th>Logo</th>
                <td><img src='<?=$logo_url?>' alt='' class="img-responsive"></td>
            </tr>
            <tr>
                <th>Username</th>
                <td id="userDetUsername"></td>
            </tr>
            <tr>
                <th>Profession</th>
                <td id="userDetProf"></td>
            </tr>
            <tr>
                <th>Tel</th>
                <td id="userDetTel"></td>
            </tr>
            <tr>
                <th>Email</th>
                <td id="userDetEmail"></td>
            </tr>
            <tr>
                <th>Address</th>
                <td><?=$address?></td>
            </tr>
            <tr>
                <th>Total Projects</th>
                <td><?=$total_projects_created?></td>
            </tr>
            <tr>
                <th>Reg Date</th>
                <td><?=$reg_date?></td>
            </tr>
        </tbody>
    </table>
    <div class="text-center">
        <button type="button" class="btn btn-primary vup">View User's Projects</button>
    </div>
</div>