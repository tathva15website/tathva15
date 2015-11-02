$(document).ready(function(){

	$("form").hide()


	$("#permodal").click(function(){
		$("#openModal").addClass("modalDialog_open");
		$("#frames").remove();
		$("#openModal div").append("<iframe id=\"frames\" src=\"modal.html\"" + "></iframe>");
	})

	$(".eventreg").click(function(){
		$("#openModal").addClass("modalDialog_open");		
		$("#frames").remove();
		var link="eventmodal.php?EventCode="
		var eventid = $(this).closest(".content__item").attr("href")
		var newlink = "'" + link + eventid + "'"
		console.log(newlink)
		$("#openModal div").append("<iframe id=\"frames\" src=" + newlink + "></iframe>");
	})

    $("#magnify").click(function(){
    	$("#cd-vertical-nav").hide()
    	$(".cd-bouncy-nav-trigger").hide();
    })

    $("#close").click(function(){
    	$("#cd-vertical-nav").show("slow")
    	$(".cd-bouncy-nav-trigger").show("slow");
    })
	
	$("#openModal .close1").click(function(){
			$("#openModal").removeClass("modalDialog_open");
			return false;
	});

})