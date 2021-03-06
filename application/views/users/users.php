<?php
defined('BASEPATH') OR exit('Get out of here');
?>

<div class="row hidden-print">
    <div class="col-sm-12">
        <div class="pwell">
            <!-- Header (add new user, sort order etc.) -->
            <div class="row">
                <div class="col-sm-12">
                    <div class="col-sm-2 fa fa-user-plus pointer" style="color:#337ab7" data-target='#addNewUserModal' data-toggle='modal'>
                        New User
                    </div>
                    <div class="col-sm-3 form-inline form-group-sm">
                        <label for="userListPerPage">Show</label>
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
                        <label for="userListPerPage">per page</label>
                    </div>
                    <div class="col-sm-4 form-inline form-group-sm">
                        Sort by 
                        <select id="userListSortBy" class="form-control">
                            <option value="username-ASC" selected>Username (A to Z)</option>
                            <option value="username-DESC">Username (Z to A)</option>
                            <option value="profession-ASC">Profession (A to Z)</option>
                            <option value="profession-DESC">Profession (Z to A)</option>
                        </select>
                    </div>
                    <div class="col-sm-3 form-inline form-group-sm">
                        <label for="userSearch"><i class="fa fa-search"></i></label>
                        <input type="search" id="custSearch" placeholder="Search Users" class="form-control">
                    </div>
                </div>
            </div>
            
            <hr>
            <!-- Header (sort order etc.) ends -->
            
            <!-- User info -->
            <div class="row" id="allUsersDiv">
                <div class="col-sm-12">
                    <!-- User's list -->
                    <div class="col-sm-12" id="allUsers"></div>
                     <!-- User's list end -->
                    
                    <!-- User details -->
                    <div class="col-sm-4" id="userInfo"></div>
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
<div class='modal fade' id='addNewUserModal' role="dialog" data-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class='modal-header'>
                <button class="close" data-dismiss='modal'>&times;</button>
                <h4 class="text-center">Add New User</h4>
                <div class="text-center">
                    <i id="fMsgIcon"></i>
                    <span id="fMsg"></span>
                </div>
            </div>
            <div class="modal-body">
                <form id='addNewUserForm' name='addNewUserForm' role='form'>
                    <div class="row">
                        <div class="form-group-sm col-sm-4">
                            <label for='username' class="control-label">Username</label>
                            <input type="text" id='username' class="form-control checkField" placeholder="Username">
                            <span class="help-block errMsg" id="usernameErr"></span>
                        </div>
                        <div class="form-group-sm col-sm-4">
                            <label for='firstName' class="control-label">First Name</label>
                            <input type="text" id='firstName' class="form-control checkField" placeholder="First Name">
                            <span class="help-block errMsg" id="firstNameErr"></span>
                        </div>
                        <div class="form-group-sm col-sm-4">
                            <label for='lastName' class="control-label">Last Name</label>
                            <input type="text" id='lastName' class="form-control checkField" placeholder="Last Name">
                            <span class="help-block errMsg" id="lastNameErr"></span>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="form-group-sm col-sm-4">
                            <label for='email' class="control-label">Email</label>
                            <input type="email" id='email' class="form-control checkField" placeholder="Email">
                            <span class="help-block errMsg" id="emailErr"></span>
                        </div>
                        <div class="form-group-sm col-sm-4">
                            <label for='mobile1' class="control-label">Phone Number</label>
                            <input type="tel" id='mobile1' class="form-control checkField" placeholder="Phone Number">
                            <span class="help-block errMsg" id="mobile1Err"></span>
                        </div>
                        <div class="form-group-sm col-sm-4">
                            <label for='mobile2' class="control-label">Other Number</label>
                            <input type="tel" id='mobile2' class="form-control" placeholder="Other Number(optional)">
                            <span class="help-block errMsg" id="mobile2Err"></span>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="form-group-sm col-sm-4">
                            <label for='profession' class="control-label">Profession</label>
                            <input type="text" id='profession' class="form-control checkField" placeholder="Profession">
                            <span class="help-block errMsg" id="professionErr"></span>
                        </div>
                        <div class="form-group-sm col-sm-4">
                            <label for='password' class="control-label">Password</label>
                            <input type="password" id='password' class="form-control checkField" placeholder="Password">
                            <span class="help-block errMsg" id="passwordErr"></span>
                        </div>
                        <div class="form-group-sm col-sm-4">
                            <label for='passwordConf' class="control-label">Confirm Password</label>
                            <input type="password" id='passwordConf' class="form-control checkField" placeholder="Profession">
                            <span class="help-block errMsg" id="passwordConfErr"></span>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="form-group-sm col-sm-12">
                            <label for='street' class="control-label">Street</label>
                            <textarea id='street' class="form-control" placeholder="Street"></textarea>
                            <span class="help-block errMsg" id="streetErr"></span>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="form-group-sm col-sm-4">
                            <label>City:</label>
                            <input type="text" class="form-control" id="city" placeholder="City">
                            <span class="help-block errMsg" id="cityErr"></span>
                        </div>
                        <div class="form-group-sm col-sm-4">
                            <label>State:</label>
                            <input type="text" class="form-control" id="state" placeholder="State">
                            <span class="help-block errMsg" id="stateErr"></span>
                        </div>
                        <div class="form-group-sm col-sm-4">
                            <label>Country:</label>
                            <input type="text" class="form-control" id="country" placeholder="Country" value="Nigeria">
                            <span class="help-block errMsg" id="countryErr"></span>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-sm-12">
                            <input type="file" id='logo' class="form-control">
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="reset" form="addNewUserForm" class="btn btn-warning pull-left">Reset Form</button>
                <button type='button' id='addUserSubmit' class="btn btn-primary">Add User</button>
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
                <h4 class="text-center">Edit User Info</h4>
                <div class="text-center">
                    <i id="fMsgEditIcon"></i>
                    <span id="fMsgEdit"></span>
                </div>
            </div>
            <div class="modal-body">
                <form id='editUserForm' name='editUserForm' role='form'>
                    <div class="row">                    
                    <div class="row">
                        <div class="form-group-sm col-sm-4">
                            <label for='usernameEdit' class="control-label">Username</label>
                            <input type="text" id='usernameEdit' class="form-control" placeholder="Username">
                            <span class="help-block" id="usernameEditErr"></span>
                        </div>
                        <div class="form-group-sm col-sm-4">
                            <label for='firstNameEdit' class="control-label">First Name</label>
                            <input type="text" id='firstNameEdit' class="form-control checkField" placeholder="First Name">
                            <span class="help-block errMsg" id="firstNameEditErr"></span>
                        </div>
                        <div class="form-group-sm col-sm-4">
                            <label for='lastNameEdit' class="control-label">Last Name</label>
                            <input type="text" id='lastNameEdit' class="form-control checkField" placeholder="Last Name">
                            <span class="help-block errMsg" id="lastNameEditErr"></span>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="form-group-sm col-sm-4">
                            <label for='emailEdit' class="control-label">Email</label>
                            <input type="email" id='emailEdit' class="form-control" placeholder="Email (optional)">
                            <span class="help-block errMsg" id="emailEditErr"></span>
                        </div>
                        <div class="form-group-sm col-sm-6">
                            <label for='mobile1Edit' class="control-label">Phone Number</label>
                            <input type="tel" id='mobile1Edit' class="form-control checkField" placeholder="Phone Number">
                            <span class="help-block errMsg" id="mobile1EditErr"></span>
                        </div>
                        <div class="form-group-sm col-sm-6">
                            <label for='mobile2Edit' class="control-label">Other Number</label>
                            <input type="tel" id='mobile2Edit' class="form-control" placeholder="Other Number (optional)">
                            <span class="help-block errMsg" id="mobile2EditErr"></span>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="form-group-sm col-sm-12">
                            <label for='professionEdit' class="control-label">Profession</label>
                            <input type="text" id='professionEdit' class="form-control checkField" placeholder="Profession">
                            <span class="help-block errMsg" id="professionEditErr"></span>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="form-group-sm col-sm-12">
                            <label for='streetEdit' class="control-label">Street</label>
                            <textarea id='streetEdit' class="form-control checkField" placeholder="Street"></textarea>
                            <span class="help-block errMsg" id="streetEditErr"></span>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="form-group-sm col-sm-4">
                            <label for="cityEdit" class="control-label">City:</label>
                            <input type="text" class="form-control checkField" id="cityEdit" placeholder="City">
                            <span class="help-block errMsg" id="cityEditErr"></span>
                        </div>
                        <div class="form-group-sm col-sm-4">
                            <label for="stateEdit" class="control-label">State:</label>
                            <input type="text" class="form-control checkField" id="stateEdit" placeholder="State">
                            <span class="help-block errMsg" id="stateEditErr"></span>
                        </div>
                        <div class="form-group-sm col-sm-4">
                            <label for="countryEdit" class="control-label">Country:</label>
                            <input type="text" class="form-control checkField" id="countryEdit" placeholder="Country">
                            <span class="help-block errMsg" id="countryEditErr"></span>
                        </div>
                    </div>
                    
                    <input type="hidden" id="userId">
                </form>
            </div>
            <div class="modal-footer">
                <button type="reset" form="editUserForm" class="btn btn-warning pull-left">Reset Form</button>
                <button type='button' id='editCustSubmit' class="btn btn-primary">Update</button>
                <button type='button' class="btn btn-danger" data-dismiss='modal'>Close</button>
            </div>
        </div>
    </div>
</div>
<!--- end of modal to edit user details --->
<script src="<?=base_url()?>public/js/users.js"></script>