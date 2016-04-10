<?php
defined('BASEPATH') OR exit('');
?>
<div class="pwell blogDetail">
    <button class="close" id="cud">&times;</button>
    <table class="table table-bordered table-responsive">
        <h4 class="text-center text-uppercase" id="blogDetName"></h4>
        <span class="hidden" id="curDisplayedBlogId"></span>
        <tbody>
            <tr>
                <th>Logo</th>
                <td><img src='<?=$logo_url?>' alt='' class="img-responsive"></td>
            </tr>
            <tr>
                <th>Title</th>
                <td id="blogDetTitle"></td>
            </tr>
            <tr>
                <th>Author</th>
                <td id="blogDetAuthor"></td>
            </tr>
            <tr>
                <th>Uploader</th>
                <td id="blogDetUpload"></td>
            </tr>
            <tr>
                <th>Created</th>
                <td><?=$created_on?></td>
            </tr>
            <tr>
                <th>Published</th>
                <td><?=$published?></td>
            </tr>
        </tbody>
    </table>
</div>