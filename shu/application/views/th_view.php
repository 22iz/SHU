<!DOCTYPE HTML>
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>有树 | 可能是最美的树洞</title>
	<link rel="stylesheet" type="text/css" href="style.css" media="all" />
 	<link rel="stylesheet" type="text/css" href="./fancybox/jquery.fancybox-1.3.4.css" media="screen" />
 </head>
<body>
	<div class="show_img" id="show_img">
		<img src="" alt="" class="show_img" id="show_img">
	</div>
	<div class="th_bg" id="th_bg"></div>
	<div class="th_crown" id="th_crown">
			<div class="th_crown_wrapper" id="th_crown_wrapper">
				<img src="image/logo.png" alt="Developed by Uicer." />
				<div class="th_sendbox" id="th_sendbox">
					<div class="th_sendbox_wrapper">
						<div class="sendbox">
							<img class="sendbox_bg" id="sendbox_bg" src="image/background/finish.png">


							
							<div id = 'logBox'>
								<a href="/shu/index.php/logout">logout</a>
								
							</div>


							<textarea id="sendbox">喂~ 树洞君~ 你还好吗？</textarea>
							<div class="choose">
								<div class="choose_button">
									<a class="emotionButton" id="emotionButton" href="javascript:void(0)"><img class="emotionButton" src="./image/post-face.gif" alt=""><span class="emotionButton">表情</span></a>
									<a class="uploadButton" id="upload_pictureButton" href="javascript:void(0)"><img class="uploadButton" src="./image/post-pic.gif" alt=""><span class="uploadButton">图片</span></a>
									<p class='show_text' id='show_text'>还没戳手印呢^_^</p>
									<p class='fobidden_text' id='fobidden_text'>不能再戳了0_0</p>
									<p class="fail_text" id="fail_text">发送失败- -||||</p>
									<p class='count_text' id="count_text">已戳了<span class="count_num" id="count_num">0</span>手印</p>
								</div>
								<a class="post" id="post" href="javascript:void(0)"><img src="./image/sp_button/post1.png"/></a>
								<!-- <a href="" class="login" id="login"><img src="./image/sp_button/login1.png" alt=""></a> -->
							</div>
							<div class="emotion">
								<div class="emo_choose">
									<a href="javascript:void(0)" class="emo_choose" id="emo_choose">心情</a>
									<a href="javascript:void(0)" class="emo_choose" id="emo_choose">浪小花</a>
									<a href="javascript:void(0)" class="emo_choose" id="emo_choose">hello菜菜</a>
									<a href="javascript:void(0)" class="emo_choose" id="emo_choose">癫当</a>
									<a href="javascript:void(0)" class="emo_choose" id="emo_choose">面瘫萝卜</a>
									<a href="javascript:void(0)" class="emo_choose" id="emo_choose">罗小黑</a>
									<a href="javascript:void(0)" class="emo_choose" id="emo_choose">冷兔</a>
									<a href="javascript:void(0)" class="emo_choose" id="emo_choose">小幺鸡</a>
								</div>
								<div class="emo_img_wrapper">
									<div class="emo_img"></div>	
								</div>
							</div>		
						</div>
						<div class="thumbnail" id="thumbnail">
							<a href="" id="thumbnail"><img src="" alt="" class="thumbnail" id="thumbnail"></a>
						</div>
					</div>
				</div>
			</div>
			<div class="th_crown_mid" id="th_crown_mid">
				<div class="th_crown_mid_wrapper">
					<h1 class="changeTip" id="changeTip">往下“挖挖看”</h1>
					<h4>大家朝树洞共吼了<span id='post'> X </span>声</h4>
				</div>
			</div>
		</div>
	<div class="th_root" id="th_root"></div>
	<div class="ground">
		<a href="javascript:void(0);" class="ground" id="ground">返回地面</a>
	</div>
	<div class="more">
		<a href="javascript:void(0);" class="more" id="more"><img id="more" src="image/sp_button/more.png" alt=""></a>
	</div>
</div>
<img src="" alt="" class="load_img" id="load_img">
<script type="text/javascript" src="./JS/jquery-1.7.2.js"></script>
<script type="text/javascript" src="./JS/ajaxupload.3.5.js"></script>
<script type="text/javascript" src="./fancybox/jquery.mousewheel-3.0.4.pack.js"></script>
<script type="text/javascript" src="./fancybox/jquery.fancybox-1.3.4.pack.js"></script>
<script type="text/javascript" src="./JS/setCursorPosition.js"></script>
	<script type="text/javascript">
	jQuery(document).ready(function($){
	var post_control,box_text,text,reply_text,mid,domindex,page,is_do,control,i,emo_text,element,stop,commentClick,repostClick,emoRecord,count,emo_show;
	emo_show=commentClick=repostClick=1;
	emoRecord=[];
	//1:评论 2:转发
	post_control=null;
	box_text='喂~ 树洞君~ 你还好吗？';
	//默认page，用于加载评论,默认morepage,用于加载更多微博
	page=1;
	//更新控制,是否评论控制，是否转发控制，是否发生到树洞
	is_do=i=count=0;
	//文本框字数控制
	$("textarea").keyup(function(){
		var str;
		str=$(this).val();
		if(str.length>140){
		str=str.substring(0,140);
			$(this).val(str);
		}
	});
	$("textarea#sendbox").live({
		keyup:function(){
					$('span#count_num').html($(this).val().length);
					if($(this).val().length>=140){
						$('p#fobidden_text').show();
						$('p#count_text').hide();
					}else{
						$('p#count_text').show();
						$('p#fobidden_text').hide();
					}
				},
				focus:function(){
					if ($(this).val()==box_text) {
							$(this).val('');
					}
					if($(this).val().length<140){
							$('p#show_text').hide();
							$('p#count_text').show();
					}else{
						$('p#show_text').hide();
						$('p#count_text').hide();
					}
					$('span#count_num').html($(this).val().length);
					if($(this).val().length>=140){
						$('p#fobidden_text').show();
						$('p#count_text').hide();
					}else{
						$('p#count_text').show();
						$('p#fobidden_text').hide();
					}
				}
	});
	// $("textarea#sendbox").focus(function(){
	
	
	// });

	$("textarea#sendbox").blur(function(){
		if($(this).val()==''){
			$(this).val(box_text);
			$('p#count_text').hide();
			$('p#show_text').show();
			$('p#fail_text').hide();
		 }
	});
	//用户发送树洞微博	
			$('a#post').click(function(){
				if(checkText($('#sendbox').val())!=box_text){
					postWeibo($('#sendbox').val(),$('img#thumbnail').attr('src'));
				}else{
					$('#sendbox').focus();
				}
			});	
			$('img#sendbox_bg').click(function(){
				$(this).hide();
				$('#sendbox').show();
				$('#show_text').show();
			});
		$('#upload_pictureButton').click(function(){	
				$('#uploadInput').click();				
		});
		var btnUpload=$("#upload_pictureButton");
		new AjaxUpload(btnUpload, {
			action: './index.php/ajax/upload',
			name: 'pic',
			responseType:'json',
			onComplete:function(name,response){
				info=$('<p />');
				info.addClass('alert');
				if(response=='fail'){
					info.html('上传发生错误').appendTo('div#thumbnail');
				}
				else if(response=='format'){
					info.html('文件格式错误').appendTo('div#thumbnail');
				}
				else{
					$('#sendbox').focus();
					uploadImg_url=response;
					var img=new Image();
					img.src=response;
					$('img#thumbnail').attr('src',response);
					$('a#thumbnail').attr('href',response);
					$('a#thumbnail').fancybox();
					if(img.complete){
						setThumbnail(img.width,img.height);
					}
					img.onload=function(){
						img.onload=null;
						setThumbnail(img.width,img.height);	
					}
					function setThumbnail(width,height){
						var imgRatio;
						imgRatio=(width>height)?height/width:width/height;
						if(width/height>=1.727){
							if(width>380){
								height=(height*380)/width;
								width=380;
							}else{
								height=220;
								width=380;
							}
						}else{
							if(height>220){
								width=(width*380)/height;
								height=220;
							}else{
								height=220;
								width=380;
							}
						}
						$('img#thumbnail').width(width);
						$('img#thumbnail').height(height);						
					}
					$('div#thumbnail').show();
					$('div.emotion').hide();
				}
			}
		});
	
	//加载树根部分
		$("#th_crown_mid").toggle(
			function(){
			$('div#th_bg').slideUp();
			$('div#th_crown_wrapper').slideUp(function(){
				$('div#show_img').slideUp(function(){
					$('#th_crown_mid').height('116px');
					$('#th_crown_mid').animate({top:'0px'},"slow");
					$('#th_root').css('margin-top','115px');
					$('#th_root').show();
					$('#changeTip').html('我想说点什么');
					$('.more').show();
					$('.ground').show();
					
				loadWeibo(0,count=count+8);
				});
			});
		},
		function(){
			$('#th_root').empty();
			checkHeight();
			$('.more').hide();
			$('.ground').hide();
			$('div#th_bg').slideDown();
			$('#th_root').css('margin-top','');
			$('div#th_crown_mid').stop().css('top','');
			$('div#th_crown_wrapper').slideDown(function(){
					$('div#show_img').slideDown(function(){
					$('#changeTip').html('往下挖挖看');
				});
			});
		});
		
	//加载前一页评论
	$('a#preLink').live('click',function(){
			loadpage=$(this).siblings('#pageNum').text();
			mid=$(this).parent().siblings('.th_choose').children('.comment').attr('id');
			if(loadpage>1){
				loadpage--;
				$(this).siblings('span#pageNum').text(loadpage);
				domindex=$(this).parent().siblings('div.comment').index('div.comment');
				loadComment(loadpage,mid,domindex);
			}
	});
	//加载下一页评论
	$('a#nextLink').live('click',function(){
		$(this).each(function(){
			pageTotal=$(this).siblings('#total').text();
		loadpage=$(this).siblings('#pageNum').text();
		mid=$(this).parent().siblings('.th_choose').children('.comment').attr('id');
		if(loadpage<pageTotal){
			loadpage++;
			$(this).siblings('span#pageNum').text(loadpage);
			domindex=$(this).parent().siblings('div.comment').index('div.comment');
			loadComment(loadpage,mid,domindex);
		}	
		});
	});
	$('a.comment').live('click',function(e){
		mid=$(this).attr('id');
		domindex=$(this).index('a.comment');
		if(commentClick){
			post_control='comment';
			$($('.root_textarea').get(domindex)).show().focusEnd();
			$($('p.comment').get(domindex)).show().siblings('p.repost').hide();
			$($('a.root_post').get(domindex)).show();
			$($('input.check').get(domindex)).show();
			$($('span.check_comment').get(domindex)).hide();
			$($('span.check_repost').get(domindex)).show();
			if($($('span.comment').get(domindex)).html()!="0"){
				loadComment(page,mid,domindex);
			}
			commentClick=0;
			repostClick=1;
		}else{
			post_control=null;
			$($('p.comment').get(domindex)).hide();
			$($('.root_textarea').get(domindex)).hide();
			$($('a.root_post').get(domindex)).hide();
			$($('span.check_repost').get(domindex)).hide();
			$($('input.check').get(domindex)).hide();
			$($('div.comment').get(domindex)).empty();
			$($('div.page').get(domindex)).empty();
			commentClick=1;
		}
	});
	$('a.repost').live('click',function(){
		mid=$(this).attr('id');
		domindex=$(this).index('a.repost');
		if(repostClick){
			post_control='repost';
			$($('.root_textarea').get(domindex)).show().focusEnd();
			$($('p.repost').get(domindex)).show().siblings('p.comment').hide();
			$($('a.root_post').get(domindex)).show();
			$($('input.check').get(domindex)).show();
			$($('span.check_repost').get(domindex)).hide();
			$($('span.check_comment').get(domindex)).show();
			$($('div.comment').get(domindex)).empty();
			$($('div.page').get(domindex)).empty();
			repostClick=0;
			commentClick=1;
		}else{
			post_control=null
			$($('.root_textarea').get(domindex)).hide();
			$($('p.repost').get(domindex)).hide();
			$($('a.root_post').get(domindex)).hide();
			$($('input.check').get(domindex)).hide();
			$($('span.check_comment').get(domindex)).hide();
			$($('div.page').get(domindex)).empty();
			repostClick=1;
		}
	});
	$('a.reply').live('click',function(){
		reply_text='回复 @'+$(this).siblings('span.userName').html();
		$(this).parents('div.comment').siblings('.root_textarea').val('').val(reply_text).focusEnd();
	});

	$('a.root_post').live('click',function(){
		domindex=$(this).index('a.root_post');
		text=$($('.root_textarea').get(domindex)).val();
		if($($('input.check').get(domindex)).attr('checked')){
			is_do=1;
		}
		switch(post_control){
			case 'comment':
				sendComment(text,mid,is_do,domindex);
				loadComment(page,mid,domindex);
			break;
			case 'repost':
				postRepost(text,mid,is_do,domindex);
			break;
		}
		$($('input.check').get(domindex)).attr('checked',false);
		is_do=0;
	});
	//显示更多树洞微博
		$("a#more").click(function(){
			query();
			loadWeibo(0,count=count+8);
		});

		$('a#ground').click(function(){
			$('body').scrollTop(0);
			
		});
		$(window).scroll(function(){
			if($("#th_root").css('display')!='none'){
			var scrollTop = 0;
		    var clientHeight = 0;
		    var scrollHeight = 0;
		    if (document.documentElement && document.documentElement.scrollTop) {
		    	scrollTop = document.documentElement.scrollTop;
		    } else if (document.body) {
		        scrollTop = document.body.scrollTop;
		    }
		    if (document.body.clientHeight && document.documentElement.clientHeight) {
		        clientHeight = (document.body.clientHeight < document.documentElement.clientHeight) ? document.body.clientHeight: document.documentElement.clientHeight;
		    } else {
		        clientHeight = (document.body.clientHeight > document.documentElement.clientHeight) ? document.body.clientHeight: document.documentElement.clientHeight;
		    }
		    scrollHeight = Math.max(document.body.scrollHeight, document.documentElement.scrollHeight);
		    if (scrollTop + clientHeight >= scrollHeight) {
				query();
				loadWeibo(0,count=count+8);
		    } else {
		        return ;
		    }
		}
		});
	//加载表情
	$('a#emotionButton').click(function(){
		if(emo_show){
			$('div.emotion').show();
			$('div.emotion').css('z-index',3);
			emo_show=0;
		}else{
			$('div.emotion').hide();
			emo_show=1;
		}
	});
	$('a#emo_choose').click(function(){
		text=$(this).text();
		loadEmotion(text);
	});
	$('a.emotion').live("click",function(){
		$('#sendbox').focusEnd();
		emo_text=$('#sendbox').val()+$(this).attr('id');
		$('#sendbox').val(emo_text);
		if($('#sendbox').val().length>140){
			str=$('#sendbox').val();
			str=str.substring(0,140);
			$('#sendbox').val(str);
		}
	});
	$(window).resize(function(){
		checkHeight();
	});
});	
	function postWeibo(text,url){
		$.post("./index.php/ajax/post",{text:text,img_url:url},function(result,status){
			if(status=='success'){
				$('textarea#sendbox').val('');
				$('textarea#sendbox').blur();
				$('#sendbox').hide();
				$('#sendbox_bg').show();
				$('#fail_text').hide();
				$('#show_text').hide();
				$('div#thumbnail').hide();
				$('img#thumbnail').attr('src','');
			}else{
				$('#fail_text').show();
				$('#show_text').hide();
				$('#count_text').hide();
				$('#sendbox').blur();
			}
		});
	}
	function checkText(text){
		var resetText;
		reg=/(^\s+)|(\s+$)/g;
		resetText=text.replace(reg,'');
		$('#sendbox').val(resetText).focusEnd();
		return resetText;
	}

	function transfEmo(weibo,count){
		var Emo;
		var sendEmo;
		reg=/\[.(?:[\u4E00-\u9FA5\w\d]+)\]/g;
		for(i=0;i<count-1;i++){
			Emo=weibo[i].text.match(reg);
			if (Emo!=null) {
				for(j=0;j<Emo.length;j++){
					sendEmo=JSON.stringify(Emo);
					$.post('./index.php/ajax/emotion',{emo:sendEmo},function(response){

					});	
				}
			}
		}	
	}
	function loadEmotion(fcategory){
			$.post('./index.php/ajax/emotion',{category:fcategory},function(response){
				$('div.emo_img').empty();
				if(response.length>91){
					length=response.length-2;
				}else{
					length=response.length-1;
				}
				var j;
				j=0;
				while(j!=length){
					createEmotion(j,response[j].phrase,response[j].url);
					if(j!==length){
						j++;	
					}
				}
			},'json');
	}
	function createEmotion(domindex,phrase,url){
		var emo_link=$('<a />');
			var emo_img=$('<img />');
			emo_link.addClass('emotion');
			emo_img.addClass('emotion');
			emo_img.appendTo(emo_link);
			emo_link.attr('href','javascript:void(0)');
			$(emo_link).appendTo('div.emo_img');
			$($('a.emotion').get(domindex)).attr('id',phrase);
			$($('img.emotion').get(domindex)).attr({title:phrase,src:url});
	}
	function postRepost(ftext,fmid,is_comment,domindex){
		$.post('./index.php/ajax/repost',
				{text:ftext,mid:fmid,is_comment:is_comment},
				function(response,status){
					$($('span#span_comment').get(domindex)).html(response.comment); 
			  		$($('span#span_repost').get(domindex)).html(response.rt);
			  		$($('.root_textarea').get(domindex)).attr("disabled","disabled");
			  		if (status=='success') {
			  			$($('.root_textarea').get(domindex)).val('').removeAttr("disabled");
			  		}else{
			  			$($('.root_textarea').get(domindex)).removeAttr("disabled");
			  		}
			  		
				},'json'
			);
	}

	function sendComment(ftext,fmid,is_repost,domindex){
			$.post('./index.php/ajax/sendComment',
					{text:ftext,mid:fmid,is_repost:is_repost},
					function(response,status){
			  				$($('span#span_comment').get(domindex)).html(response.comment); 
			  				$($('span#span_repost').get(domindex)).html(response.rt);
			  				$($('.root_textarea').get(domindex)).attr('disabled','disabled');
			  				if(status==='success'){
				  				$($('.root_textarea').get(domindex)).val('').removeAttr('disabled');
			  				}else{
			  					$($('.root_textarea').get(domindex)).removeAttr('disabled');
			  				}
				
						},'json'
					);
	}
	function loadComment(fpage,mid,domindex){
		$.post('./index.php/ajax/loadComment',
				{mid:mid,page:fpage},
				function(response,status){
					if (status=='success') {
						$($('span#span_comment').get(domindex)).html(response.comment); 
			  			$($('span#span_repost').get(domindex)).html(response.rt);
						$($('div.comment').get(domindex)).empty();
						for (var i =0; i<response['text'].length; i++) {
							var pComment;
							pComment=createComment(response['text'][i].text,response['text'][i].user,response['text'][i].cid);
							$($('div.comment').get(domindex)).append(pComment);
						}
						if(response.comment>5){
			  				createPage(response.comment,domindex,fpage);
			  			}
					}
				},'json'
			);
	}
	function createComment(cText,cUser,cid){
				var pComment=$('<p />');
				var spanUser=$('<span />');
				var replyButton=$('<a />');
				pComment.addClass('cText');
				spanUser.addClass('userName');
				replyButton.addClass('reply');
				spanUser.attr('id','userName');
				replyButton.attr({id:cid,href:'javascript:void(0);'});
				replyButton.html('-回复');
				spanUser.html(cUser+':');
				spanUser.appendTo(pComment);
				pComment.append(cText);
				replyButton.appendTo(pComment);
				return pComment;
	}
	function createRootBranch(leftBranchRoot,leftBranchWrapper,rightBranchRoot,rightBranchWrapper,BranchElement){
		for(i=0;i<=3;i++){
			createLeft(leftBranchRoot.clone(),leftBranchWrapper.clone(),BranchElement.clone());
			createRight(rightBranchRoot.clone(),rightBranchWrapper.clone(),BranchElement.clone());
		}
	}
	function createRight(rightRoot,wrapper_right,elementRight){
				elementRight.appendTo(wrapper_right);
				wrapper_right.appendTo(rightRoot);
				rightRoot.appendTo('div#th_root');
	}
	function createLeft(leftRoot,wrapper_left,elementLeft){
				elementLeft.appendTo(wrapper_left);
				wrapper_left.appendTo(leftRoot);
				leftRoot.appendTo('div#th_root');
	
	}
	//微博加载函数
	function loadWeibo(domindex,count){
		var url='./image/sp_button/loading.gif';
		$('a#more').unbind('false');
		$('img#more').attr('src',url);
					$.post('./index.php/ajax/load',{count:count},function(weibo,status){
						if(status=='success'){
							var leftRoot,rightRoot,leftWrapper,rightWrapper,element;
							leftRoot=$('<div class="left"></div>');
							rightRoot=$('<div class="right"></div>');
							leftWrapper=$('<div class="wrapper_left"></div>');
							rightWrapper=$('<div class="wrapper_right"></div>');		
							element=$('<div class="entry"> \
								<div class="root_text"> \
									<p class="post_text"></p> \
								</div> \
									<div class="repost"> \
										<p class="repost_text"></p> \
									</div> \
									<div class="th_choose"> \
										<a href="javascript:void(0)" class="repost" id="">转发(<span class="reply" id="span_repost"></span>)</a> \
										<a href="javascript:void(0)" class="comment" id="">评论(<span class="comment" id="span_comment"></span>)</a> \
										<p class="repost">转发说说</p> \
										<p class="comment">评论说说</p> \
									</div> \
											<textarea class="root_textarea"></textarea> \
										<div class="th_root_button"> \
											<input type="checkbox" class="check" id="check"><span class="check_repost">同时转发到树洞</span><span class="check_comment">同时评论到此微博</span> \
											<a href="javascript:void(0)" class="root_post" id=""><img src="./image/sp_button/post-comment.png"></a> \
										</div> \
									<div class="comment"></div> \
									<div class="page"></div> \
							</div>');
							createRootBranch(leftRoot,leftWrapper,rightRoot,rightWrapper,element);
							appendContent(domindex,count,weibo);
							$('a#more').bind('click');
							$('img#more').attr('src','./image/sp_button/more.png');
						}
						// transfEmo(weibo,count);
					},"json");				
	}
	function appendContent(domindex,count,weibo){
		for(cleanIndex=0;cleanIndex<=count-1;cleanIndex++){
			destory(cleanIndex);
		}
		lastIndex=count-1;
		if(count>8){
			for(lastStart=count-4;lastStart<=count-1;lastStart++){
				$($('p.post_text').get(lastStart)).html(weibo[lastStart].text);
				$($('span.comment').get(lastStart)).html(weibo[lastStart].cCount);
				$($('span.reply').get(lastStart)).html(weibo[lastStart].rCount);
				$($('a.comment').get(lastStart)).attr("id",weibo[lastStart].mid);
				$($('a.repost').get(lastStart)).attr("id",weibo[lastStart].mid);
				$($('a.root_post').get(lastStart)).attr("id",weibo[lastStart].mid);
				$($('p.repost_text').get(lastStart)).html('');
				if (weibo[lastStart].repost!=null) {
					$($('p.repost_text').get(lastStart)).html(weibo[lastStart].repost);
					if(weibo[lastStart].repost_img!=null){
					createImg(1,weibo[lastStart].repost_original_pic,weibo[lastStart].repost_img,lastStart);
					}
				}
				if(weibo[lastStart].img!=null){
					createImg(0,weibo[lastStart].original_pic,weibo[lastStart].img,lastStart);
				}
			}
			lastIndex=count-5;
		}
		for(;domindex<=lastIndex;domindex++){
			$($('p.post_text').get(domindex)).html(weibo[domindex].text);
			$($('span.comment').get(domindex)).html(weibo[domindex].cCount);
			$($('span.reply').get(domindex)).html(weibo[domindex].rCount);
			$($('a.comment').get(domindex)).attr("id",weibo[domindex].mid);
			$($('a.repost').get(domindex)).attr("id",weibo[domindex].mid);
			$($('a.root_post').get(domindex)).attr("id",weibo[domindex].mid);
			$($('p.repost_text').get(domindex)).html('');
			if (weibo[domindex].repost!=null) {
				$($('p.repost_text').get(domindex)).html(weibo[domindex].repost);
				if(weibo[domindex].repost_img!=null){
				createImg(1,weibo[domindex].repost_original_pic,weibo[domindex].repost_img,domindex);
				}
			}
			if(weibo[domindex].img!=null){
				createImg(0,weibo[domindex].original_pic,weibo[domindex].img,domindex);
			}
		}
	}
	//更新时先清除图片
	function destory(domindex){
		$($('div.comment').get(domindex)).empty();
		$($('div.page').get(domindex)).empty();
		$($('p.post_text').get(domindex)).siblings('a#large_pic').remove();
	}
	function createImg(is_repost,img_ori_src,img_src,domindex){
		var img=$('<img />');
		var img_link=$('<a />');
		var obj;
		img.addClass('large_pic');
		img_link.addClass('large_pic');
		img_link.attr({href:img_ori_src,id:'large_pic'});
		img.attr({src:img_src});
		img.appendTo(img_link);
		obj=$($('div.root_text').get(domindex));
		if(is_repost){
			obj=$($('div.repost').get(domindex));
		}
		obj.find('a#large_pic').remove();
		obj.append(img_link);
		$('a#large_pic').fancybox();
	}
	function query(){
		$('span#post').load('./index.php/ajax/query');
	}
function createPage(count,domindex,cPage){
		var preLink=$('<a />');
		var nextLink=$('<a />');
		var pageOutput=$('<span />');
		var pageTotalCount=$('<span />');
		var page=$('<span />');
		preLink.attr({'href':'javascript:void(0)','class':'page','id':'preLink','title':'前一页'});
		preLink.html('<<');
		nextLink.attr({'href':'javascript:void(0)','class':'page','id':'nextLink','title':'后一页'});
		nextLink.html('>>');
		pageOutput.attr({'class':'page','id':'total'});
		pageOutput.html(Math.ceil(count/5));
		page.attr({'class':'page','id':'pageNum'});
		page.html(cPage);
		$($('div.page').get(domindex)).empty().append(preLink).append(page).append('of ').append(pageOutput).append(nextLink);
}
//背景控制
$(window).load(function(){
		query();
		checkHeight(loadBackground);
	});
	function checkHeight(callback){
    	height=$(window).height()-116;
   		th_height=height-119;
   		$('div.th_sendbox').height(th_height);
   		$('div#th_bg').height(height);
		$('div#show_img').height(height);
		uri='<?php echo $imgUrl; ?>'+Math.floor(Math.random()*6+1)+'.jpg';
		$('img#load_img').attr('src',uri);
		if(typeof(callback)=='function'){
    		callback($('img#load_img').attr('src'));			
		}
    }	
    function loadBackground(url){
    		var img=new Image();
	        img.src=url;
	        if($('#load_img').attr('src')!=''){
				if(img.complete){
					$('img#show_img').attr('src',url);
					$('div#th_bg').stop().fadeTo(4000,0);
	            	return;
		    	}
	        	img.onload=function(){
	        		img.onload=null;
					$('img#show_img').attr('src',url);
					$('div#th_bg').stop().fadeTo(4000,0);;            	
	            }
	        	img.onerror=function(){
	            	$('div#th_bg').css('background-image','url("image/crown_bg/loading.png")');
	        	}
	        }else{
	        	$('div#th_bg').css('background-image','url("image/crown_bg/loading.png")');
	        }
	}
	//google analytic
  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-34866203-1']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>
</body>
</html>