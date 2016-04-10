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
                        <select id="blogListPerPage" class="form-control">
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
                        <select id="blogListSortBy" class="form-control">
                            <option value="title-ASC" selected>Title (A to Z)</option>
                            <option value="title-DESC">Title (Z to A)</option>
                            <option value="date_created-ASC">Date Created (Ascending)</option>
                            <option value="date_created-DESC">Date Created (Descending)</option>
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
            
            <!-- Blog info -->
            <div class="row" id="allBlogsDiv">
                <div class="col-sm-12">
                    <!-- Blog's list -->
                    <div class="col-sm-12" id="allBlogs"></div>
                     <!-- Blog's list end -->
                    
                    <div class="col-sm-12 hidden" id="editBlogDiv">
                        <div class="row">
                            <i class="fa fa-times pull-right text-danger pointer closeEditBlog"></i>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-sm-12">
                                <center><img src="" id='logoEdit' class="img-responsive" width="600px" height="400px"></center>
                                <br>
                                <label>Change Image(max file size; 500kb):</label>
                                <input type="file" id="newLogo" class="form-control">
                            </div>
                        </div>
                        
                        <form id='editBlogForm' name='editBlogForm' role='form'>
                            <div class="row">
                                <div class="form-group col-sm-12">
                                    <label for='authorEdit' class="control-label">Author</label>
                                    <input type="text" id='authorEdit' class="form-control checkField" placeholder="Author">
                                    <span class="help-block errMsg" id="authorEditErr"></span>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="form-group col-sm-12">
                                    <label for='titleEdit' class="control-label">Title</label>
                                    <input type="text" id='titleEdit' class="form-control checkField" placeholder="Title">
                                    <span class="help-block" id="titleEditErr"></span>
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group col-sm-12">
                                    <label for='bodyEdit' class="control-label">Body</label>
                                    <textarea id='bodyEdit' class="form-control checkField" rows="10" cols="40" placeholder="Add Blog Content"></textarea>
                                    <span class="help-block errMsg" id="bodyEditErr"></span>
                                </div>
                            </div>

                            <input type="hidden" id="blogId">
                            
                            <div class="row">
                                <div class="col-sm-12">
                                    <button class="btn btn-primary" id="editBlogSubmit">Update</button>
                                    <button class="btn btn-danger closeEditBlog">Close</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- Blog list ends -->
        </div>
    </div>
</div>

<!--- Modal to add new blog --->
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
                        <div class="form-group-sm col-sm-12">
                            <label for='title' class="control-label">Title</label>
                            <input type="text" id='title' class="form-control checkField" placeholder="Title">
                            <span class="help-block errMsg" id="titleErr"></span>
                        </div>
                    </div>
                    
					<div class="row">
                        <div class="form-group-sm col-sm-12">
                            <label for='author' class="control-label">Author</label>
                            <input type="text" id='author' class="form-control checkField" placeholder="Author">
                            <span class="help-block errMsg" id="authorErr"></span>
                        </div>
                    </div>
					
                    <div class="row">
                        <div class="form-group-sm col-sm-12">
                            <label for='body' class="control-label">Body</label>
                            <textarea id='body' class="form-control checkField" placeholder="Add Blog Content" rows="5" cols="40"></textarea>
                            <span class="help-block errMsg" id="bodyErr"></span>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-sm-12">
							<center><img src="" class="img-responsive" id="prevBlogImg"></center>
                            <label>Blog Image(max file size; 500kb):</label>
                            <input type="file" id='logo' class="form-control">
							<span class='help-block errMsg' id='logoErr'></span>
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
<!--- end of modal to add new blog --->
<script src="<?=base_url()?>public/js/blog.js"></script>