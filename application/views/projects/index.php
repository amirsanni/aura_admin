<?php
defined('BASEPATH') OR exit('Get out of here');
?>

<div class="row hidden-print">
    <div class="col-sm-12">
        <div class="pwell">
            <!-- Header (add new user, sort order etc.) -->
            <div class="row">
                <div class="col-sm-12">
                    <div class="col-sm-4 form-inline form-group-sm">
                        <label for="projListPerPage">Show</label>
                        <select id="projListPerPage" class="form-control">
                            <option value="1">1</option>
                            <option value="5">5</option>
                            <option value="10" selected>10</option>
                            <option value="15">15</option>
                            <option value="20">20</option>
                            <option value="30">30</option>
                            <option value="50">50</option>
                            <option value="100">100</option>
                        </select>
                        <label for="projListPerPage">per page</label>
                    </div>
                    <div class="col-sm-4 form-inline form-group-sm">
                        <label for="projListSortBy">Sort by </label>
                        <select id="projListSortBy" class="form-control">
                            <option value="title-ASC" selected>Title (A to Z)</option>
                            <option value="title-DESC">Title (Z to A)</option>
                            <option value="date_created-ASC">Date (oldest first)</option>
                            <option value="date_created-DESC">Date (recent first)</option>
                        </select>
                    </div>
                    <div class="col-sm-4 form-inline form-group-sm">
                        <label for="projSearch"><i class="fa fa-search"></i></label>
                        <input type="search" id="custSearch" placeholder="Search Projects" class="form-control">
                    </div>
                </div>
            </div>
            
            <hr>
            <!-- Header (sort order etc.) ends -->
            
            <!-- Projects Table -->
            <div class="row" id="allProjDiv"></div>
            <!-- Projects Table ends -->
        </div>
    </div>
</div>

<script src="public/js/projects.js"></script>