<?php
defined('BASEPATH') OR exit('Get out of here');
?>

<div class="row hidden-print">
    <div class="col-sm-12">
        <div class="pwell">
            <!-- Header (add new user, sort order etc.) -->
            <div class="row">
                <div class="col-sm-12">
                    <div class="col-sm-2 fa fa-rss pointer" style="color:#337ab7" data-target='#addNewBlogModal' data-toggle='modal'>
                        Create New Blog
                    </div>
                    <div class="col-sm-3 form-inline form-group-sm">
                        <label for="blogListPerPage">Show</label>
                        <select id="userListPerPage" class="form-control">
                            <option value="1">1</option>
                            <option value="5">5</option>
                            <option value="10" selected>10</option>
                            <option value="15">15</option>
                            <option value="20">20</option>
                            <option value="30">30</option>
                            <option value="50">50</option>
                            <option value="100">100</option>
                        </select>
                        <label for="blogListPerPage">per page</label>
                    </div>
                    <div class="col-sm-4 form-inline form-group-sm">
                        Sort by 
                        <select id="userListSortBy" class="form-control">
                            <option value="title-ASC" selected>Title (A to Z)</option>
                            <option value="title-DESC">Title (Z to A)</option>
                            <option value="created-ASC">Date Created (Ascending)</option>
                            <option value="created-DESC">Date Created (Descending)</option>
                        </select>
                    </div>
                    <div class="col-sm-3 form-inline form-group-sm">
                        <label for="blogSearch"><i class="fa fa-search"></i></label>
                        <input type="search" id="custSearch" placeholder="Search Blogs" class="form-control">
                    </div>
                </div>
            </div>
            
            <hr>
            <!-- Header (sort order etc.) ends -->
            
            <!-- User info -->
            <div class="row" id="allUsersDiv">
                <div class="col-sm-12">
                    <!-- User's list -->
                    <div class="col-sm-12" id="allBlogs"></div>
                     <!-- User's list end -->
                    
                    <!-- User details -->
                    <div class="col-sm-4" id="blogInfo"></div>
                     <!-- User details end -->
                </div>
            </div>
            <!-- User list ends -->
        </div>
    </div>
</div>



<!--- A particular user's Projects--->
<div class="row hidden-print">
    <div class="col-sm-12 hidden" id="userProjectList">
        <div class="pwell">
            <div class="row">
                <div class="col-sm-12">
                    <span class="close" style="color:red" id="closeUserProjectList">&times;</span>
                </div>
                <div class="col-sm-12">
                    <h5 class="text-center text-uppercase" id="userProjectsInfo"></h5>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-sm-12">
                    <div class="col-sm-2" id="userProjectListRange"></div>
                    <div class="col-sm-3">
                        Show <select id="userProjectListPerPage">
                            <option value="1">1</option>
                            <option value="5">5</option>
                            <option value="10" selected>10</option>
                            <option value="15">15</option>
                            <option value="20">20</option>
                        </select> per page
                    </div>
                    <div class="col-sm-4">
                        Sort by
                        <select id="userProjectListSortBy">
                            <option value="title-ASC" selected>Title(A to Z)</option>
                            <option value="category-ASC">Category (A to Z)</option>
                            <option value="date_created-DESC">Date Created(recent first)</option>
                            <option value="last_edited-DESC">Date Edited(recent first)</option>
                            <option>---</option>
                            <option value="title-DESC" selected>Title(Z to A)</option>
                            <option value="category-DESC">Category (Z to A)</option>
                            <option value="date_created-ASC">Date Created(oldest first)</option>
                            <option value="last_edited-ASC">Date Edited(oldest first)</option>
                        </select>
                    </div>
                    <div class="col-sm-3">
                        <input type="search" id="searchUserProjectList" class="form-control" placeholder="Search...">
                    </div>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-sm-12" id="userProjectListTable"></div>
                <div id="userProjectPaginationLinks" class="text-center"></div>
            </div>
        </div>
    </div>
</div>
<!--- End of user's project list--->

<!--- Modal to add new user --->
<div class='modal fade' id='addNewBlogModal' role="dialog" data-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class='modal-header'>
                <button class="close" data-dismiss='modal'>&times;</button>
                <h4 class="text-center">Add New Blog</h4>
                <div class="text-center">
                    <i id="fMsgIcon"></i>
                    <span id="fMsg"></span>
                </div>
            </div>
            <div class="modal-body">
                <form id='addNewBlogForm' name='addNewBlogForm' role='form'>
                    <div class="row">
                        <div class="form-group-sm col-sm-4">
                            <label for='title' class="control-label">Title</label>
                            <input type="text" id='title' class="form-control checkField" placeholder="Title">
                            <span class="help-block errMsg" id="titleErr"></span>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="form-group-sm col-sm-9">
                            <label for='body' class="control-label">Body</label>
                            <textarea id='body' class="form-control checkField" placeholder="Add Blog Content" rows="5" cols="40"></textarea>
                            <span class="help-block errMsg" id="bodyErr"></span>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="form-group-sm col-sm-4">
                            <label for='author' class="control-label">Author</label>
                            <input type="text" id='author' class="form-control checkField" placeholder="Author">
                            <span class="help-block errMsg" id="authorErr"></span>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-sm-12">
                            <label>Blog Image:</label>
                            <input type="file" id='logo' class="form-control">
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="reset" form="addNewBlogForm" class="btn btn-warning pull-left">Reset Form</button>
                <button type='button' id='addBlogSubmit' class="btn btn-primary">Add Blog</button>
                <button type='button' class="btn btn-danger" data-dismiss='modal'>Close</button>
            </div>
        </div>
    </div>
</div>
<!--- end of modal to add new user --->


<!--- Modal for editing user details --->
<div class='modal fade' id='editUserModal' role="dialog" data-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class='modal-header'>
                <button class="close" data-dismiss='modal'>&times;</button>
                <h4 class="text-center">Edit Blog Details</h4>
                <div class="text-center">
                    <i id="fMsgEditIcon"></i>
                    <span id="fMsgEdit"></span>
                </div>
            </div>
            <div class="modal-body">
                <form id='editUserForm' name='editBlogForm' role='form'>
                    <div class="row">                    
                    
                    <div class="row">
                        <div class="form-group-sm col-sm-4">
                            <label for='titleEdit' class="control-label">Title</label>
                            <input type="text" id='titleEdit' class="form-control" placeholder="Title">
                            <span class="help-block" id="titleEditErr"></span>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="form-group-sm col-sm-4">
                            <label for='bodyEdit' class="control-label">Body</label>
                            <input type="text" id='bodyEdit' class="form-control checkField" placeholder="Body">
                            <span class="help-block errMsg" id="bodyEditErr"></span>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="form-group-sm col-sm-4">
                            <label for='authorEdit' class="control-label">Author</label>
                            <input type="text" id='authorEdit' class="form-control checkField" placeholder="Author">
                            <span class="help-block errMsg" id="authorEditErr"></span>
                        </div>
                    </div>
                        
                    </div>
                    
                    <input type="hidden" id="userId">
                </form>
            </div>
            <div class="modal-footer">
                <button type="reset" form="editBlogForm" class="btn btn-warning pull-left">Reset Form</button>
                <button type='button' id='editBlogSubmit' class="btn btn-primary">Update</button>
                <button type='button' class="btn btn-danger" data-dismiss='modal'>Close</button>
            </div>
        </div>
    </div>
</div>
<!--- end of modal to edit user details --->
<script src="<?=base_url()?>public/js/blog.js"></script>