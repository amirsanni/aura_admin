'use strict';

$(document).ready(function(){
    lap_();
});



function lap_(){
    var orderBy = $("#projListSortBy").val().split("-")[0];
    var orderFormat = $("#projListSortBy").val().split("-")[1];
    var limit = $("#projListPerPage").val();
    
    $("#allProjDiv").load(appRoot+'projects/lap_', {orderBy:orderBy, orderFormat:orderFormat, limit:limit});
}