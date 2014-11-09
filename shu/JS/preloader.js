//图片预加载
	$.fn.preloader=function(){
		$(this).imgload('image/crown_bg/test.png',null);
	}
	$.fn.imgload=function(url){
		var img=new Image();
		img.src=url;
		if(img.complete){
			$(this).css("background-image","url('image/crown_bg/test.png')");
		}
		img.onload=function() {
			img.onload=null;
		}
		function process(){
			
		}	
	}