'use strict';

$(document).ready(function(){
    //checkDocumentVisibility(checkLogin);//check document visibility in order to confirm blog's log in status
    
    //load all blog posts once the page is ready
    //function header: lab_(url)
    lab_();
    
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    
    //reload the list of blogs when fields are changed
    $("#blogListSortBy, #blogListPerPage").change(function(){
        displayFlashMsg("Please wait...", spinnerClass, "", "");
        lab_();
    });
    
    
    
    //to view a blog's project list
    $("#blogInfo").on('click', '.vup', function(){
        vup_();
    });
    
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    
    
    //reload the list of blog's projects when fields are changed
    $("#blogProjectListSortBy, #blogProjectListPerPage").on('change', function(){
        displayFlashMsg("Please wait...", spinnerClass, "", "");
        vup_();
    });
    
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    
    //load and show page when pagination link on blogs' list table is clicked
    $("#allBlogs").on('click', '.lnp', function(e){
        e.preventDefault();
		
        displayFlashMsg("Please wait...", spinnerClass, "", "");

        lab_($(this).attr('href'));

        return false;
    });
    
       
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    
    //when a blog's name is clicked. More detaila about the blog will be displayed to the right
    //gumd = "Get blog more details"
    $("#allBlogs").on('click', '.gumd', function(){
        var blogId = $(this).prop('id').split("-")[1];
        
        blogId ? gumd_(blogId) : "";//call the function to get and display details if blogId is set
    });
    
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    
    //close the small div shown to the right of the blogs' list table when button with id "cud" is clicked
    $("#blogInfo").on('click', '#cud', cud_);
    
    
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
    
    
    //handles the addition of new blog details .i.e. when "add blog" button is clicked   $("#addBlogSubmit").click(function(e){    ...$('#addBlogSubmit').on('click', 'div', function(e) {
       $("#addBlogSubmit").click(function(){ 
       	confirm("I am an alert box!");
        e.preventDefault();
        
        //reset all error msgs in case they are set
        changeInnerHTML(['titleErr', 'bodyErr', 'authorErr'], "");
        
        var title = $("#title").val();
        var body = $("#body").val();
        var author = $("#author").val();
        
        //ensure all required fields are filled
        if(!title || !body || !author){
            !title ? changeInnerHTML('titleErr', "required") : "";
            !body ? changeInnerHTML('bodyErr', "required") : "";
            !author ? changeInnerHTML('authorErr', "required") : "";
            
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
        formInfo.append("title", title);
        formInfo.append("body", body);
        formInfo.append("author", author);
        
        //display message telling blog action is being processed
        $("#fMsgIcon").attr('class', spinnerClass);
        $("#fMsg").html(" Processing...");
        
        //make ajax request if all is well
        $.ajax({
            method: "POST",
            url: appRoot+"blogs/add",
            data: formInfo,
            cache: false,
            processData: false,
            contentType: false
        }).done(function(returnedData){
                $("#fMsgIcon").removeClass();//remove spinner
                
                if(returnedData.status === 1){
                    $("#fMsg").css('color', 'green').html("Blog post added");
                    
                    //reset the form and close the modal
                    document.getElementById("addNewBlogForm").reset();
					
                    //reset the form and close the modal
                    setTimeout(function(){
                        $("#fMsg").html("");
                        $("#addNewBlogModal").modal('hide');
                    }, 2000);
                    
                    //reset all error msgs in case they are set
                    changeInnerHTML(['titleErr', 'bodyErr', 'authorErr'], "");
                    
                    //refresh blogs list table
                    lab_();                    
                }
                
                else{
                    //display error message returned
                    $("#fMsg").css('color', 'red').html(returnedData.msg);

                    //display individual error messages if applied
                    $("#titleErr").html(returnedData.blogname);
                    $("#bodyErr").html(returnedData.first_name);
                    $("#authorErr").html(returnedData.last_name);
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
    $("#editBlogSubmit").click(function(e){
        e.preventDefault();
        
        //reset all error msgs in case they are set
        changeInnerHTML(['titleEditErr', 'bodyEditErr', 'authorEditErr'], "");
        
        var title = $("#titleEdit").val();
        var body = $("#bodyEdit").val();
        var author = $("#authorEdit").val();
        
        //ensure all required fields are filled
        if(!title || !body || !author){
            !title ? changeInnerHTML('titleEditErr', "required") : "";
            !body ? changeInnerHTML('bodyEditErr', "required") : "";
            !author ? changeInnerHTML('authorEditErr', "required") : "";
                        
            return;
        }
        
        if(!custId){
            $("#fMsgEdit").text("An error occured while trying to update blog's details");
            return;
        }
        
        //display message telling blog action is being processed
        $("#fMsgEditIcon").attr('class', spinnerClass);
        $("#fMsgEdit").text(" Updating details...");
        
        //make ajax request if all is well
        $.ajax({
            method: "POST",
            url: appRoot+"blogs/update",
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
                    lab_();
					
					//call function to send SMS to blog
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
            lab_();
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
     * When the close button is clicked on the div showing the list of a projects created by a blog
     */
    $("#closeblogProjectList").click(function(){
        $("#blogProjectList").addClass('hidden');//hide the div
        $("#allblogsDiv").removeClass('hidden');
        
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
 * gumd = "get blog more details". This includes other than customer's bio
 * @param {type} blogId
 * @returns {Boolean}
 */
function gumd_(blogId){
    if(blogId && (blogId !== $("#curDisplayedblogId").html())){
        //hide the currently displayed blog's created project (in case there is one there)
        $("#blogProjectList").addClass('hidden');
        
        //change the length of the blog list table div to 8 to allow blog's info to be displayed to the right
        $("#allblogs").attr('class', 'col-sm-8');
        
        $("#blogInfo").html("<i class='fa fa-spinner faa-spin animated'></i> Loading...");

        //make server request to get information about blog        
        $("#blogInfo").load(appRoot+"blogs/get_blog_more_details", {blog_id:blogId}, function(response, status, xhr){            
            if(status === "success"){
                //append blog's details we already have to their appropriate places
                ////get the details of the blog from the bloglist table
                $("#blogDetName").html($("#blog-"+blogId).html());
                $("#curDisplayedblogId").html(blogId);
                $("#blogDetblogname").html($("#uListblogname-"+blogId).html());
                $("#blogDetProf").html($("#uListProf-"+blogId).html());
                $("#blogDetTel").html($("#uListTel-"+blogId).html());
                $("#blogDetEmail").html($("#uListEmail-"+blogId).html());
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
 * vup_ = "View blog's Projects"
 * @param {type} cId
 * @param {type} url
 * @returns {Boolean}
 */
function vup_(url){
    var blogId = $("#curDisplayedblogId").html();
    var orderBy = $("#blogProjectListSortBy").val().split("-")[0] ;
    var orderFormat = $("#blogProjectListSortBy").val().split("-")[1];
    var limit = $("#blogProjectListPerPage").val();

    //make server request to get information about customer
    $.ajax({
        type: "get",
        url: url ? url : appRoot+"blogs/get_blog_projects",
        data: {blog_id:blogId, order_by:orderBy, order_format:orderFormat, limit:limit}
    }).done(function(returnedData){
            if(returnedData.status === 1){
                $("#blogProjectsInfo").text(returnedData.blogName+"'s Projects");
                $("#blogProjectListRange").text(returnedData.range);
                
                $("#blogProjectListTable").html(returnedData.blogProjectListTable);
                $("#blogProjectPaginationLinks").html(returnedData.links);
                
                //now make the div visible and hide the div displaying blog's list
                $("#allblogsDiv").addClass('hidden');
                $('#blogProjectList').removeClass('hidden');
                
                
                //scroll down to the history div
                $('html, body').animate({
                    scrollTop: $("#blogProjectList").offset().top
                }, 1000);
				
				
                hideFlashMsg();
            }

            else{
                displayFlashMsg("blog is yet to create any project", "", "red", 1500);
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
 * lab_ = "Load all blogs"
 * @returns {undefined}
 */
function lab_(url){
    var orderBy = $("#blogListSortBy").val().split("-")[0];
    var orderFormat = $("#blogListSortBy").val().split("-")[1];
    var limit = $("#blogListPerPage").val();
    
    $.ajax({
        method:'get',
        url: url ? url : appRoot+"blogs/lab_/",
        data: {orderBy:orderBy, orderFormat:orderFormat, limit:limit},
        
        success: function(returnedData){
            hideFlashMsg();
			
            $("#allBlogs").html(returnedData.blogsTable);
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
	
    lab_(url);
    
    return false;
}

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

/**
 * Load pages when pagination links are clicked on a blog's projects' list
 * lupnp = "Load blog's project next page"
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
 * cud = "Close blog detail"
 * @returns {undefined}
 */
function cud_(){
    //change the length of the blog list table div to 12 to remove blog's info from the right
    $("#allBlogs").attr('class', 'col-sm-12');
    
    $("#blogInfo").html("");//remove the html in the blogDetail div
    
    //hide the currently displayed blog's created projects (in case there is one there)
    $("#blogProjectList").addClass('hidden');
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
