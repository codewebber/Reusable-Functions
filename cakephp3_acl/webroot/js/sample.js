$(document).ready(function () {
	var l = window.location;
	var base_url = l.protocol + "//" + l.host + "/" + l.pathname.split('/')[1] + "/";
	$('#selected-area').append("<div class='selected_item'><span class='value'>hello</span><img src='"+base_url+"/img/cake.icon.png' class='img-responsive close'></div>");
});