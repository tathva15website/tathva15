$(".stack-bouncygrid div").click(function(){
		if($(".stack-bouncygrid").hasClass("active_lectures")){
				$(".stack-bouncygrid").removeClass("active_lectures");
				$(this).addClass("active_img");
				console.log(this);
			}else{
					$(".stack-bouncygrid div").removeClass("active_img");
					
					$(".stack-bouncygrid").addClass("active_lectures");
				}
	});