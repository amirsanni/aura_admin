'use strict';

$(document).ready(function(){
    lap_();
    
    
    //TO CHANGE SORT ORDER OR NUMBER OF PAGES SHOWN PER PAGE
    $("#projListPerPage, #projListSortBy").change(function(){
        lap_();
    });
    
    
    
    //TO SEARCH THROUGH PROJECTS TABLE
    $("#projSearch").keyup(function(){
    	var valueToSearch = $(this).val();
    	
    	if(valueToSearch){
    		
    		$("#allProjDiv").html("<i class='"+spinnerClass+"'></i> Searching...");
    		
    		$.ajax({
    			method: "get",
    			url: appRoot+"search/ps",
    			data: {v:valueToSearch}
    		}).done(function(returnedData){
    			$("#allProjDiv").html(returnedData);
    		}).fail(function(){
    			checkBrowserOnline(false);
    		});
    	}
    	
    	else{
    		lap_();
    	}
    });
    
    
    
    //WHEN PAGINATION IS CLICKED
    $("#allProjDiv").on('click', '.nxtProj', function(e){
    	e.preventDefault();
    	
    	var url = $(this).attr('href');
    	
    	lap_(url);
    });
    
    
    
    
    //TO PUBLISH/UNPUBLISH A PROJECT
    $("#allProjDiv").on('click', '.pubProj', function(){
        var clickedElemIcon = $(this).children('i');
        
        var projId = $(this).prop("id").split("-")[1];
        var ns = clickedElemIcon.hasClass('fa fa-toggle-on') ? 0 : 1;
        
        if(projId){
            
        	//show spinner to indicate "loading"
            clickedElemIcon.removeClass().addClass(spinnerClass);
            
            $.ajax({
                url: appRoot+"projects/paup",
                method: "GET",
                data: {pId:projId, ns:ns}
            }).done(function(returnedData){
                if(returnedData.status === 1){
                    clickedElemIcon.removeClass(spinnerClass);
                    
                    clickedElemIcon.addClass(ns === 1 ? "fa fa-toggle-on" : "fa fa-toggle-off");
                }
                
                else{
                    //display error message and return toggle back to its original
                	displayFlashMsg("Unable to process your request, pls try again later", '', 'red', 5000);
                	
                	//if ns (new status) is 1 (i.e. to publish), it means project was previously unpublished, so set it as unpublished
                	clickedElemIcon.addClass(ns === 1 ? "fa fa-toggle-off" : "fa fa-toggle-on");
                }
            });
        }
    });
    
    
    /*
    ********************************************************************************************************************************
    ********************************************************************************************************************************
    ********************************************************************************************************************************
    ********************************************************************************************************************************
    ********************************************************************************************************************************
    */
    
    
    //TO DELETE A PROJ
    $("#allProjDiv").on('click', '.delProj', function(){
    	var projId = $(this).parents('td').siblings("input[type=hidden]").val();
    	
    	var conf = window.confirm("Are you sure you want to delete project?");
    	
    	if(conf){
    		var clickedElem = $(this);//get the clicked button
    		var prevHTML = $(this).html();//get the 'html' displayed on the button
    		
    		$(this).html("<i class='"+spinnerClass+" fa-lg'></i> Deleting");//display spinner on the button
    		
    		//make server req
    		$.ajax({
        		url: appRoot+"projects/del_proj",
        		method: "get",
        		data: {id:projId}
        	}).done(function(returnedData){
        		if(returnedData.status === 1){
        			//remove row from table and reset the table number
        			$(clickedElem).parents('tr').remove();
        			
        			//resetNumber(elem, prefix, suffix)
        			resetNumber('.projSn', '', '.');
        			
        			displayFlashMsg("Project successfully deleted", '', 'green', 2000);
        		}
        	}).fail(function(){
        		checkBrowserOnline(false);
        		
        		//reset the button back to the default
        		clickedElem.html(prevHTML);
        	});
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



/**
 * lap = "Load All Projects"
 */
function lap_(url){
	$("#allProjDiv").html("<i class='"+spinnerClass+"'></i> Loading...");
	
	var urlToCall = url ? url : appRoot+'projects/lap_';
	
    var orderBy = $("#projListSortBy").val().split("-")[0];
    var orderFormat = $("#projListSortBy").val().split("-")[1];
    var limit = $("#projListPerPage").val();
    
    $("#allProjDiv").load(urlToCall, {orderBy:orderBy, orderFormat:orderFormat, limit:limit});
}