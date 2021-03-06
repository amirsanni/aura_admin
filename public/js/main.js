'use strict';

var spinnerClass = 'fa fa-spinner faa-spin animated';

/*
 * set the appRoot
 * The below line will work for both http, https with or without www
 * @type String
 */
var appRoot = setAppRoot("aura_admin", "");


$(document).ready(function(){
    //for tooltips
    $('[data-toggle="tooltip"]').tooltip();
    
    /*
    ********************************************************************************************************************************
    ********************************************************************************************************************************
    ********************************************************************************************************************************
    ********************************************************************************************************************************
    ********************************************************************************************************************************
    */
    
    
    
    
    /*
    ********************************************************************************************************************************
    ********************************************************************************************************************************
    ********************************************************************************************************************************
    ********************************************************************************************************************************
    ********************************************************************************************************************************
    */
    
    //To validate form fields
    $('form').on('change', '.checkField', function(){
        
        if($(this).val()){
            $(this).css({borderColor:''});
        }

        else{
            $(this).css({borderColor:'red'});
        }
    });
    
    /*
    ********************************************************************************************************************************
    ********************************************************************************************************************************
    ********************************************************************************************************************************
    ********************************************************************************************************************************
    ********************************************************************************************************************************
    */
   
    //WHEN THE SUBMIT BUTTON ON THE LOG IN MODAL IS CLICKED
    $("#loginModalSubmit").click(function(e){
        e.preventDefault();
        
        var email = $("#logInModalEmail").val();
        var password = $("#logInModalPassword").val();
       
       if(!email || !password){
           //display error message
           $("#logInFMsg").css('color', 'red').html("Please enter both your email and password");
           return;
       }
       
       
       //display progress message
       $("#logInFMsg").css('color', 'black').html("Authenticating. Please wait...");
       
       
       //call function to handle log in and get the returned data through a callback
       handleLogin(appRoot+"home/login", email, password, function(returnedData){
           if(returnedData.status === 1){
                $("#logInFMsg").css('color', 'green').html(returnedData.msg);

                location.reload(true);
            }

            else{
                //display error message
                $("#logInFMsg").css('color', 'red').html(returnedData.msg);
            }
       });
       
    });
   
    /*
    ********************************************************************************************************************************
    ********************************************************************************************************************************
    ********************************************************************************************************************************
    ********************************************************************************************************************************
    ********************************************************************************************************************************
    */
});



/*
********************************************************************************************************************************
********************************************************************************************************************************
********************************************************************************************************************************
********************************************************************************************************************************
********************************************************************************************************************************
*/


/**
 * Change the class name of elements
 * @param {type} elementId
 * @param {type} newClassName
 * @returns {String}
 */
function changeClassName(elementId, newClassName){
    
    //just change value if it's a single element
    if(typeof(elementId) === "string"){
        $("#"+elementId).attr('class', newClassName);
    }
    
    //loop through if it's an array
    else{
        var i;
    
        for(i in elementId){
            $("#"+elementId[i]).attr('class', newClassName);
        }
    }
    return "";
}



/*
********************************************************************************************************************************
********************************************************************************************************************************
********************************************************************************************************************************
********************************************************************************************************************************
********************************************************************************************************************************
*/


/**
 * Change the innerHTML of elements
 * @param {type} elementId
 * @param {type} newValue
 * @returns {String}
 */
function changeInnerHTML(elementId, newValue){
    //just change value if it's a single element
    if(typeof(elementId) === "string"){
        $("#"+elementId).html(newValue);
    }
    
    //loop through if it's an array
    else{
        var i;
    
        for(i in elementId){
            $("#"+elementId[i]).html(newValue);
        }
    }
    
    
    return "";
}


/*
********************************************************************************************************************************
********************************************************************************************************************************
********************************************************************************************************************************
********************************************************************************************************************************
********************************************************************************************************************************
*/


/**
 * Function to handle the display of messages
 * @param {type} msg
 * @param {type} iconClassName
 * @param {type} color
 * @param {type} time
 * @returns {undefined}
 */
function displayFlashMsg(msg, iconClassName, color, time){
    changeClassName('flashMsgIcon', iconClassName);//set spinner class name
    $("#flashMsg").css('color', color);//change font color
    changeInnerHTML('flashMsg', msg);//set message to display
    $("#flashMsgModal").modal('show');//display modal
    
    //hide the modal after a specified time if time is specified
    if(time){
        setTimeout(function(){$("#flashMsgModal").modal('hide');}, time);
    }
}



/*
********************************************************************************************************************************
********************************************************************************************************************************
********************************************************************************************************************************
********************************************************************************************************************************
********************************************************************************************************************************
*/


/**
 * 
 * @returns {undefined}
 */
function hideFlashMsg(){
    changeClassName('flashMsgIcon', "");//set spinner class name
    $("#flashMsg").css('color', '');//change font color
    changeInnerHTML('flashMsg', "");//set message to display
    $("#flashMsgModal").modal('hide');//hide modal
}



/*
********************************************************************************************************************************
********************************************************************************************************************************
********************************************************************************************************************************
********************************************************************************************************************************
********************************************************************************************************************************
*/


/**
 * Change message being displayed and hide the modal if time is set
 * @param {type} msg
 * @param {type} iconClassName
 * @param {type} color
 * @param {type} time
 * @returns {undefined}
 */
function changeFlashMsgContent(msg, iconClassName, color, time){
    changeClassName('flashMsgIcon', iconClassName);//set spinner class name
    $("#flashMsg").css('color', color);//change font color
    changeInnerHTML('flashMsg', msg);//set message to display
    
    //hide the modal after a specified time if time is specified
    if(time){
        setTimeout(function(){$("#flashMsgModal").modal('hide');}, time);
    }
}



/*
********************************************************************************************************************************
********************************************************************************************************************************
********************************************************************************************************************************
********************************************************************************************************************************
********************************************************************************************************************************
*/


/**
 * To ensure only numbers are allowed as input
 * @param {type} value
 * @param {type} elementId
 * @returns {undefined}
 */
function numOnly(value, elementId){
    $("#"+elementId).val(value.replace(/\D+/g, ""));
}



/*
********************************************************************************************************************************
********************************************************************************************************************************
********************************************************************************************************************************
********************************************************************************************************************************
********************************************************************************************************************************
*/


/**
 * ensure field is properly filled
 * @param {type} value
 * @param {type} errorElementId
 * @returns {undefined}
 * @deprecated v1.0.0
 */
function checkField(value, errorElementId){
    if(value){
        $("#"+errorElementId).html('');
    }
    
    else{
        $("#"+errorElementId).html('required');
    }
}



/*
********************************************************************************************************************************
********************************************************************************************************************************
********************************************************************************************************************************
********************************************************************************************************************************
********************************************************************************************************************************
*/


/**
 * 
 * @param {type} length
 * @returns {String}
 */
function randomString(length){
    var rand = Math.random().toString(36).slice(2).substring(0, length);
    
    return rand;
}



/*
********************************************************************************************************************************
********************************************************************************************************************************
********************************************************************************************************************************
********************************************************************************************************************************
********************************************************************************************************************************
*/



function setAppRoot(devFolderName, prodFolderName){
    var hostname = window.location.hostname;

    /*
     * set the appRoot
     * This will work for both http, https with or without www
     * @type String
     */
    
    //attach trailing slash to both foldernames
    var devFolder = devFolderName ? devFolderName+"/" : "";
    var prodFolder = prodFolderName ? prodFolderName+"/" : "";
    
    var baseURL = "";
    
    if(hostname === "localhost" || (hostname.search("192.168.0.") !== -1) || (hostname.search("127.0.0.") !== -1)){
        baseURL = window.location.origin+"/"+devFolder;
    }
    
    else{
        baseURL = window.location.origin+"/"+prodFolder;
    }
    
    return baseURL;
}




/*
********************************************************************************************************************************
********************************************************************************************************************************
********************************************************************************************************************************
********************************************************************************************************************************
********************************************************************************************************************************
*/



function scrollPageToTop(time){
    time = time ? time : 100;//set 100 as default time
    
    //scrolls to top of page
    $('html, body').animate({
        scrollTop: $("html").offset().top
    }, time);
}



/*
********************************************************************************************************************************
********************************************************************************************************************************
********************************************************************************************************************************
********************************************************************************************************************************
********************************************************************************************************************************
*/



/**
 * Check user's log in status (when page has focus) and trigger login modal if user is not logged in
 * @returns {undefined}
 */
function checkLogin(url, ajaxMethod, textToDisplay, callback){
	$.ajax({
		url: url,
		method: ajaxMethod
	}).done(function(returnedData){
		//if a callback was sent, call it.
		if(typeof callback === "function"){
			callback(returnedData.status);
		}
		
		else{//else, trigger the modal to allow user to log in
			if(returnedData.status === 0){
				var msg = textToDisplay ? textToDisplay : "Your session has expired. Please log in to continue";
				
				triggerLoginForm(msg, {'color':'red'});//trigger log in form
			}
		}
	});
}



/*
********************************************************************************************************************************
********************************************************************************************************************************
********************************************************************************************************************************
********************************************************************************************************************************
********************************************************************************************************************************
*/


/**
 * call function "functionToCall" if document has focus
 * Check Andy E's answer: https://stackoverflow.com/questions/1060008/is-there-a-way-to-detect-if-a-browser-window-is-not-currently-active
 * @param {type} functionToCall
 * @returns {undefined}
 */
function checkDocumentVisibility(functionToCall){
    var hidden = "hidden";
    
    //detect if page has focus and check login status if it does
    if(hidden in document){//for browsers that support visibility API
        $(document).on("visibilitychange", functionToCall);
    }
    
    else if ((hidden = "mozHidden") in document){
        document.addEventListener("mozvisibilitychange", functionToCall);
    }

    else if ((hidden = "webkitHidden") in document){
        document.addEventListener("webkitvisibilitychange", functionToCall);
    }

    else if ((hidden = "msHidden") in document){
        document.addEventListener("msvisibilitychange", functionToCall);
    }

    // IE 9 and lower:
    else if ("onfocusout" in document){
        document.onfocusin = document.onfocusout = functionToCall;
    }

    // All others:
    else{
      window.onpageshow = window.onpagehide = window.onfocus = window.onblur = functionToCall;
    }
}



/*
********************************************************************************************************************************
********************************************************************************************************************************
********************************************************************************************************************************
********************************************************************************************************************************
********************************************************************************************************************************
*/


function triggerLoginForm(msg, cssObj){
    $("#logInModalFMsg").css(cssObj).html(msg);

    //launch the login/signup modal
    $("#logInModal").modal('show');
}



/*
********************************************************************************************************************************
********************************************************************************************************************************
********************************************************************************************************************************
********************************************************************************************************************************
********************************************************************************************************************************
*/


/**
 * 
 * @param {type} url
 * @param {type} email
 * @param {type} password
 * @param {type} callback
 * @returns {undefined}
 */
function handleLogin(url, email, password, callback){
    var jsonToReturn = "";
    
    $.ajax(url, {
        method: "POST",
        data: {email:email, password:password}
    }).done(function(returnedData){
        if(returnedData.status === 1){
            jsonToReturn = {status:1, msg:"Authenticated."};
            typeof callback === "function" ? callback(jsonToReturn) : "";
        }

        else{
            //display error messages
            jsonToReturn = {status:0, msg:"Invalid email/password combination"};
            typeof callback === "function" ? callback(jsonToReturn) : "";
        }
    }).fail(function(){
        //set error message based on the internet connectivity of the user
        var msg = (navigator.onLine) ? "Unable to log you in at the moment. Please try again later." 
            : "Log in failed. Please check your internet connection and try again later.";
        
        //display error messages
        jsonToReturn = {status:0, msg:msg};
        typeof callback === "function" ? callback(jsonToReturn) : "";
    });
}


/*
********************************************************************************************************************************
********************************************************************************************************************************
********************************************************************************************************************************
********************************************************************************************************************************
********************************************************************************************************************************
*/


function scrollToDiv(divElem){
    $('html, body').animate({
        scrollTop: $(divElem).offset().top
    }, 1000);
}


/*
********************************************************************************************************************************
********************************************************************************************************************************
********************************************************************************************************************************
********************************************************************************************************************************
********************************************************************************************************************************
*/


/**
 * Check if browser is connected to the internet (if not on localhost) when an ajax req failed
 * @param {bool} changeFlashContent whether to display a new flash message or change the content if one is displayed
 * @returns {undefined}
 */
function checkBrowserOnline(changeFlashContent){
    if((!navigator.onLine) && (appRoot.search('localhost') === -1)){
        changeFlashContent ? 
            changeFlashMsgContent('Network Error! Please check your internet connection and try again', '', 'red', '', false) 
            : 
            displayFlashMsg('Network Error! Please check your internet connection and try again', '', 'red', '', false);
    }
    
    else{
        changeFlashContent ? 
            changeFlashMsgContent('Oops! Bug? Unable to process your request. Please try again or report error', '', 'red', '', false) 
            : 
            displayFlashMsg('Oops! Bug? Unable to process your request. Please try again or report error', '', 'red', '', false);
    }
}


/*
********************************************************************************************************************************
********************************************************************************************************************************
********************************************************************************************************************************
********************************************************************************************************************************
********************************************************************************************************************************
*/


/**
 * To Preview an image that's about to be uploaded the moment the image is selected
 * @param fileInput
 * @param imgTagId
 */
function previewImage(fileInput, imgTagId){
    if (fileInput.files) {
        var reader = new FileReader();

        reader.onload = function (e) {
            $('#'+imgTagId).attr('src', e.target.result);
        };

        reader.readAsDataURL(fileInput.files[0]);
    }
}


/*
********************************************************************************************************************************
********************************************************************************************************************************
********************************************************************************************************************************
********************************************************************************************************************************
********************************************************************************************************************************
*/


/**
 * To reshuffle the numbering of all elem with a particular class or tag
 * @param string elem the tag or class of the element to reset the numbering
 * @param string prefix a string to prepend to the number. e.g. "Number", "Question", "Volume" etc.
 * @param string suffix a string to append to the number
 */
function resetNumber(elem, prefix, suffix){
    $(elem).each(function(index){
        var sn = parseInt(index + 1);
        
        $(this).html(prefix+sn+suffix);
    });
}