<?php defined('BASEPATH') OR exit(''); ?>

<div class="table table-responsive">
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>SN</th>
                <th>Title</th>
                <th>Description</th>
                <th>Category</th>
                <th>Date Created</th>
            </tr>
        </thead>

        <tbody>
            <?php foreach ($user_projects as $get): ?>
                <tr>
                    <th><?= $sn ?>.</th>
                    <td><?= $get->title ?></td>
                    <td><?= ellipsize($get->description, 100) ?></td>
                    <td><?= $get->category_name ?></td>
                    <td><?= date('jS M, Y h:i:sa', strtotime($get->date_created)) ?></td>
                </tr>
                <?php $sn++; ?>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>