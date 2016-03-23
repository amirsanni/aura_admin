'use strict';

$(document).ready(function(){
    checkDocumentVisibility(function(){
        checkLogin(appRoot+"misc/check_session_status", "GET", "", "");
    });//check document visibility in order to confirm user's log in status
    
    //load all users once the page is ready
    //function header: lau_(url)
    lau_();
    
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    
    //reload the list of users when fields are changed
    $("#userListSortBy, #userListPerPage").change(function(){
        displayFlashMsg("Please wait...", spinnerClass, "", "");
        lau_();
    });
    
    
    
    //to view a user's project list
    $("#userInfo").on('click', '.vup', function(){
        vup_();
    });
    
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    
    
    //reload the list of user's projects when fields are changed
    $("#userProjectListSortBy, #userProjectListPerPage").on('change', function(){
        displayFlashMsg("Please wait...", spinnerClass, "", "");
        vup_();
    });
    
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    
    //load and show page when pagination link on users' list table is clicked
    $("#allUsers").on('click', '.lnp', function(e){
        e.preventDefault();
		
        displayFlashMsg("Please wait...", spinnerClass, "", "");

        lau_($(this).attr('href'));

        return false;
    });
    
    
    
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    
    //ensure only number is entered in fields
    $("#mobile1, #mobile2, #mobile1Edit, #mobile2Edit").change(function(){
        $(this).val($(this).val().replace(/\D+/g, ""));
    });
    
    
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    
    //when a user's name is clicked. More detaila about the user will be displayed to the right
    //gumd = "Get user more details"
    $("#allUsers").on('click', '.gumd', function(){
        var userId = $(this).prop('id').split("-")[1];
        
        userId ? gumd_(userId) : "";//call the function to get and display details if userId is set
    });
    
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    
    //close the small div shown to the right of the users' list table when button with id "cud" is clicked
    $("#userInfo").on('click', '#cud', cud_);
    
    
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    
    
    
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    
    
    
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    
    
    //handles the addition of new user details .i.e. when "add user" button is clicked
    $("#addUserSubmit").click(function(e){
        e.preventDefault();
        
        //reset all error msgs in case they are set
        changeInnerHTML(['usernameErr', 'firstNameErr', 'lastNameErr', 'mobile1Err', 'mobile2Err', 'emailErr', 'streetErr', 
            'cityErr', 'stateErr', 'countryErr', 'professionErr', 'passwordErr', 'passwordConfErr'], "");
        
        var username = $("#username").val();
        var firstName = $("#firstName").val();
        var lastName = $("#lastName").val();
        var mobile1 = $("#mobile1").val();
        var mobile2 = $("#mobile2").val();
        var email = $("#email").val();
        var profession = $("#profession").val();
        var password = $("#password").val();
        var passwordConf = $("#passwordConf").val();
        var street = $("#street").val();
        var city = $("#city").val();
        var state = $("#state").val();
        var country = $("#country").val();
        
        //ensure all required fields are filled
        if(!username || !firstName || !lastName || !mobile1 || !email || !profession || !password || !passwordConf){
            !firstName ? changeInnerHTML('firstNameErr', "required") : "";
            !lastName ? changeInnerHTML('lastNameErr', "required") : "";
            !mobile1 ? changeInnerHTML('mobile1Err', "required") : "";
            !email ? changeInnerHTML('emailErr', "required") : "";
            !username ? changeInnerHTML('usernameErr', "required") : "";
            !profession ? changeInnerHTML('professionErr', "required") : "";
            !password ? changeInnerHTML('passwordErr', "required") : "";
            !passwordConf ? changeInnerHTML('passwordConfErr', "required") : "";
            
            return;
        }
        
        
        var logo = document.getElementById('logo').files;

        //set info to send to server
        var formInfo = new FormData();

        for (var i = 0; i < logo.length; i++) {
            var file = logo[i];

            // Add the file to the request.
            formInfo.append("logo", file);
        }
        
        
        //add other info to the formInfo obj
        formInfo.append("username", username);
        formInfo.append("first_name", firstName);
        formInfo.append("last_name", lastName);
        formInfo.append("email", email);
        formInfo.append("mobile_1", mobile1);
        formInfo.append("mobile_2", mobile2);
        formInfo.append("profession", profession);
        formInfo.append("password", password);
        formInfo.append("passwordConf", passwordConf);
        formInfo.append("street", street);
        formInfo.append("city", city);
        formInfo.append("state", state);
        formInfo.append("country", country);
        
        //display message telling user action is being processed
        $("#fMsgIcon").attr('class', spinnerClass);
        $("#fMsg").html(" Processing...");
        
        //make ajax request if all is well
        $.ajax({
            method: "POST",
            url: appRoot+"users/add",
            data: formInfo,
            cache: false,
            processData: false,
            contentType: false
        }).done(function(returnedData){
                $("#fMsgIcon").removeClass();//remove spinner
                
                if(returnedData.status === 1){
                    $("#fMsg").css('color', 'green').html("Account created");
                    
                    //reset the form and close the modal
                    document.getElementById("addNewUserForm").reset();
					
                    //reset the form and close the modal
                    setTimeout(function(){
                        $("#fMsg").html("");
                        $("#addNewUserModal").modal('hide');
                    }, 2000);
                    
                    //reset all error msgs in case they are set
                    changeInnerHTML(['usernameErr', 'firstNameErr', 'lastNameErr', 'mobile1Err', 'mobile2Err', 'emailErr', 'streetErr', 
                        'cityErr', 'stateErr', 'countryErr', 'professionErr', 'passwordErr', 'passwordConfErr'], "");
                    
                    //refresh users list table
                    lau_();                    
                }
                
                else{
                    //display error message returned
                    $("#fMsg").css('color', 'red').html(returnedData.msg);

                    //display individual error messages if applied
                    $("#usernameErr").html(returnedData.username);
                    $("#firstNameErr").html(returnedData.first_name);
                    $("#lastNameErr").html(returnedData.last_name);
                    $("#emailErr").html(returnedData.email);
                    $("#mobile1Err").html(returnedData.mobile_1);
                    $("#mobile2Err").html(returnedData.mobile_2);
                    $("#professionErr").html(returnedData.profession);
                    $("#passwordErr").html(returnedData.password);
                    $("#passwordConfErr").html(returnedData.passwordConf);
                    $("#cityErr").html(returnedData.city);
                    $("#stateErr").html(returnedData.state);
                    $("#countryErr").html(returnedData.country);
                    $("#logoErr").html(returnedData.logo);
                }
            }).fail(function(){
                if(!navigator.onLine){
                    $("#fMsg").css('color', 'red').text("Network error! Pls check your network connection");
                }
                
                else{
                    $("#fMsg").css('color', 'red').text("Unable to process your reuest at this time");
                }
            });
    });
    
    
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    
    
    //handles the updating of customer details update
    $("#editCustSubmit").click(function(e){
        e.preventDefault();
        
        //reset all error msgs in case they are set
        changeInnerHTML(['titleEditErr', 'firstNameEditErr', 'lastNameEditErr', 'mobile1EditErr', 'mobile2EditErr', 'emailEditErr', 
            'genderEditErr', 'addressEditErr', 'cityEditErr', 'stateEditErr', 'countryEditErr', 'membershipIdEditErr'], "");
        
        var title = $("#titleEdit").val();
        var firstName = $("#firstNameEdit").val();
        var lastName = $("#lastNameEdit").val();
        var otherName = $("#otherNameEdit").val();
        var mobile1 = $("#mobile1Edit").val();
        var mobile2 = $("#mobile2Edit").val();
        var email = $("#emailEdit").val();
        var gender = $("#genderEdit").val();
        var membershipId = $("#membershipIdEdit").val();
        var address = $("#addressEdit").val();
        var city = $("#cityEdit").val();
        var state = $("#stateEdit").val();
        var country = $("#countryEdit").val();
        var custId = $("#custId").val();
        
        //ensure all required fields are filled
        if(!firstName || !lastName || !mobile1 || !email || !gender || !address || !city || !state || !country || !membershipId){
            !firstName ? changeInnerHTML('firstNameEditErr', "required") : "";
            !lastName ? changeInnerHTML('lastNameEditErr', "required") : "";
            !mobile1 ? changeInnerHTML('mobile1EditErr', "required") : "";
            !email ? changeInnerHTML('emailEditErr', "required") : "";
            !gender ? changeInnerHTML('genderEditErr', "required") : "";
            !membershipId ? changeInnerHTML('membershipIdEditErr', 'required') : "";
            !address ? changeInnerHTML('addressEditErr', "required") : "";
            !city ? changeInnerHTML('cityEditErr', 'required') : "";
            !state ? changeInnerHTML('stateEditErr', 'required') : "";
            !country ? changeInnerHTML('countryEditErr', 'required') : "";
            
            return;
        }
        
        if(!custId){
            $("#fMsgEdit").text("An error occured while trying to update customer's details");
            return;
        }
        
        //display message telling user action is being processed
        $("#fMsgEditIcon").attr('class', spinnerClass);
        $("#fMsgEdit").text(" Updating details...");
        
        //make ajax request if all is well
        $.ajax({
            method: "POST",
            url: appRoot+"customers/update",
            data: {title:title, firstName:firstName, lastName:lastName, otherName:otherName, mobile1:mobile1, mobile2:mobile2, 
                email:email, gender:gender, address:address, custId:custId, city:city, state:state, country:country,
                membershipId:membershipId},
            success: function(returnedData){
                $("#fMsgEditIcon").removeClass();//remove spinner
                
                if(returnedData.status === 1){
                    $("#fMsgEdit").css('color', 'green').text(returnedData.msg);
                    
                    //reset the form and close the modal
                    setTimeout(function(){
                        $("#fMsgEdit").text("");
                        $("#editCustModal").modal('hide');
                    }, 2000);
                    
                    //reset all error msgs in case they are set
                    changeInnerHTML(['titleEditErr', 'firstNameEditErr', 'lastNameEditErr', 'mobile1EditErr', 'mobile2EditErr', 
                        'emailEditErr', 'genderEditErr', 'addressEditErr', 'cityEditErr', 'stateEditErr', 'countryEditErr',
                        'membershipIdEditErr'], "");
                    
                    //refresh customer list table
                    lau_();
					
					//call function to send SMS to user
					//sendSMS(msg, numbers) in "main.js"
					var msgToSendAsSMS = "Your details on our server was successfully modified. Check your email for more info. Thank you.";
					
					sendSMS(msgToSendAsSMS, mobile1);
                    
                }
                
                else{
                    //display error message returned
                    $("#fMsgEdit").css('color', 'red').html(returnedData.msg);

                    //display individual error messages if applied
                    $("#titleEditErr").html(returnedData.title);
                    $("#firstNameEditErr").html(returnedData.firstName);
                    $("#lastNameEditErr").html(returnedData.lastName);
                    $("#otherNameEditErr").html(returnedData.otherName);
                    $("#mobile1EditErr").html(returnedData.mobile1);
                    $("#mobile2EditErr").html(returnedData.mobile2);
                    $("#emailEditErr").html(returnedData.email);
                    $("#genderEditErr").html(returnedData.gender);
                    $("#membershipIdEditErr").html(returnedData.membershipId);
                    $("#addressEditErr").html(returnedData.address);
                    $("#cityEditErr").html(returnedData.city);
                    $("#stateEditErr").html(returnedData.state);
                    $("#countryEditErr").html(returnedData.country);
                }
            },
            
            error: function(){
                if(!navigator.onLine){
                    $("#fMsgEdit").css('color', 'red').text("Network error! Please check your network connection");
                }
            }
        });
    });
    
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    
    
    //handles customer search
    $("#custSearch").on('keyup change', function(e){
        e.preventDefault();
        var value = $("#custSearch").val();
        
        if(value){//search only if there is at least one char in input
            $.ajax({
                type: "get",
                url: appRoot+"search/custsearch",
                data: {v:value},
                success: function(returnedData){
                    $("#allCustomers").html(returnedData.custTable);
                }
            });
        }
        
        else{
            lau_();
        }
    });
    
    
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    
    //searching through a customer's transactions history
    $("#searchCustTrans").keyup(function(){
       var value = $("#searchCustTrans").val();
        var custId = $("#curDisplayedCustId").html();

        if(value){//search only if there is at least a char in input
            $.ajax({
                type: "get",
                url: appRoot+"search/custtranssearch",
                data: {v:value, custId:custId},
                success: function(returnedData){
                    if(returnedData.status === 1){
                        $("#custTransTable").html(returnedData.custTransTable);
                    }
                }
            });
        }

        else{
            vup_();
        } 
    });
    
    
    
    /*
     * When the close button is clicked on the div showing the list of a projects created by a user
     */
    $("#closeUserProjectList").click(function(){
        $("#userProjectList").addClass('hidden');//hide the div
        $("#allUsersDiv").removeClass('hidden');
        
        //scroll page to top
        scrollPageToTop();
    });
});



/*
***************************************************************************************************************************************
***************************************************************************************************************************************
***************************************************************************************************************************************
***************************************************************************************************************************************
***************************************************************************************************************************************
*/


/**
 * To show modal to edit customer details
 * @param {type} custId
 * @returns {undefined}
 */
function editCust(custId){
    //show modal, get customer info and populate the form with it
    $("#editCustModal").modal('show');
    $("#fMsgEditIcon").attr('class', spinnerClass);
    $("#fMsgEdit").text("Fetching details...");
    
    $.ajax({
        type: "post",
        url: appRoot+"customers/getcustbio",
        data: {custId:custId},
        success: function(returnedData){
            if(returnedData.status === 1){
                $("#titleEdit").val(returnedData.title);
                $("#membershipIdEdit").val(returnedData.membershipId);
                $("#firstNameEdit").val(returnedData.firstName);
                $("#lastNameEdit").val(returnedData.lastName);
                $("#otherNameEdit").val(returnedData.otherName);
                $("#mobile1Edit").val(returnedData.mobile1);
                $("#mobile2Edit").val(returnedData.mobile2);
                $("#emailEdit").val(returnedData.email);
                $("#genderEdit").val(returnedData.gender);
                $("#addressEdit").val(returnedData.address);
                $("#cityEdit").val(returnedData.city);
                $("#stateEdit").val(returnedData.state);
                $("#countryEdit").val(returnedData.country);
                $("#custId").val(custId);
                
                $("#fMsgEdit").text("");
                $("#fMsgEditIcon").removeClass();
            }
            
            else{
                $("#fMsgEdit").text("Error fetching customer details");
                $("#fMsgEditIcon").removeClass();
            }
        }
    });
}


///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

/**
 * gumd = "get user more details". This includes other than customer's bio
 * @param {type} userId
 * @returns {Boolean}
 */
function gumd_(userId){
    if(userId && (userId !== $("#curDisplayedUserId").html())){
        //hide the currently displayed user's created project (in case there is one there)
        $("#userProjectList").addClass('hidden');
        
        //change the length of the user list table div to 8 to allow user's info to be displayed to the right
        $("#allUsers").attr('class', 'col-sm-8');
        
        $("#userInfo").html("<i class='fa fa-spinner faa-spin animated'></i> Loading...");

        //make server request to get information about user        
        $("#userInfo").load(appRoot+"users/get_user_more_details", {user_id:userId}, function(response, status, xhr){            
            if(status === "success"){
                //append user's details we already have to their appropriate places
                ////get the details of the user from the userlist table
                $("#userDetName").html($("#user-"+userId).html());
                $("#curDisplayedUserId").html(userId);
                $("#userDetUsername").html($("#uListUsername-"+userId).html());
                $("#userDetProf").html($("#uListProf-"+userId).html());
                $("#userDetTel").html($("#uListTel-"+userId).html());
                $("#userDetEmail").html($("#uListEmail-"+userId).html());
            }
        });
    }
    
    return false;
}

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    
/**
 * vup_ = "View User's Projects"
 * @param {type} cId
 * @param {type} url
 * @returns {Boolean}
 */
function vup_(url){
    var userId = $("#curDisplayedUserId").html();
    var orderBy = $("#userProjectListSortBy").val().split("-")[0] ;
    var orderFormat = $("#userProjectListSortBy").val().split("-")[1];
    var limit = $("#userProjectListPerPage").val();

    //make server request to get information about customer
    $.ajax({
        type: "get",
        url: url ? url : appRoot+"users/get_user_projects",
        data: {user_id:userId, order_by:orderBy, order_format:orderFormat, limit:limit}
    }).done(function(returnedData){
            if(returnedData.status === 1){
                $("#userProjectsInfo").text(returnedData.userName+"'s Projects");
                $("#userProjectListRange").text(returnedData.range);
                
                $("#userProjectListTable").html(returnedData.userProjectListTable);
                $("#userProjectPaginationLinks").html(returnedData.links);
                
                //now make the div visible and hide the div displaying user's list
                $("#allUsersDiv").addClass('hidden');
                $('#userProjectList').removeClass('hidden');
                
                
                //scroll down to the history div
                $('html, body').animate({
                    scrollTop: $("#userProjectList").offset().top
                }, 1000);
				
				
                hideFlashMsg();
            }

            else{
                displayFlashMsg("User is yet to create any project", "", "red", 1500);
            }
        }).fail(function(){
            if(!navigator.onLine){
                displayFlashMsg("You appear to be offline. Pls reconnect and try again. Thank you.", "", "red", "");
                
                var interval = setInterval(function(){
                    if(navigator.onLine){
                        //dismiss the modal and stop interval
                        hideFlashMsg();
                        
                        clearInterval(interval);
                    }
                }, 2000);
            }
            
            else{
                displayFlashMsg("An unexpected error occured. Pls try again later", "", "red", '');
            }
            
        });
}



///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

/**
 * lau_ = "Load all users"
 * @returns {undefined}
 */
function lau_(url){
    var orderBy = $("#userListSortBy").val().split("-")[0];
    var orderFormat = $("#userListSortBy").val().split("-")[1];
    var limit = $("#userListPerPage").val();
    
    $.ajax({
        method:'get',
        url: url ? url : appRoot+"users/lau_/",
        data: {orderBy:orderBy, orderFormat:orderFormat, limit:limit},
        
        success: function(returnedData){
            hideFlashMsg();
			
            $("#allUsers").html(returnedData.usersTable);
        },
        
        error: function(){
            
        }
    });
}

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


/**
 * handles the refreshing and loading of customer list table pages when the page numbers are clicked
 * lnp = "Load next page"
 * @param {type} url
 * @returns {Boolean}
 */
function lnp(url){
    displayFlashMsg("Please wait...", spinnerClass, "", "");
	
    lau_(url);
    
    return false;
}

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

/**
 * Load pages when pagination links are clicked on a user's projects' list
 * lupnp = "Load user's project next page"
 * @param {type} url
 * @returns {Boolean}
 */
function lupnp(url){
    displayFlashMsg("Please wait...", spinnerClass, "", "");
	
    vup_(url);
    
    return false;
}

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

/**
 * cud = "Close user detail"
 * @returns {undefined}
 */
function cud_(){
    //change the length of the user list table div to 12 to remove user's info from the right
    $("#allUsers").attr('class', 'col-sm-12');
    
    $("#userInfo").html("");//remove the html in the userDetail div
    
    //hide the currently displayed user's created projects (in case there is one there)
    $("#userProjectList").addClass('hidden');
}


///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////