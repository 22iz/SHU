<!DOCTYPE HTML>
<html lang="en-US">
<head>
	<meta charset="UTF-8">
	<title>UIC 树洞|吼一声吧</title>
	<link rel="stylesheet" type="text/css" href="mobile.css" media="all">
	<script type="text/javascript" src="./JS/jquery-1.7.2.js"></script>
	<script type="text/javascript" src="./fancybox/jquery.mousewheel-3.0.4.pack.js"></script>
	<script type="text/javascript" src="./fancybox/jquery.fancybox-1.3.4.pack.js"></script>
	<script type="text/javascript">
	jQuery(document).ready(function($) {
		var text,mid,DomIndex,page,repost,comment,height,control,i,emo_text,element,is_update,left_root,right_root,wrapper_left,wrapper_right; 
		element=$('<div class="entry"> \
						<div class="root_text"> \
							<p class="post_text"></p> \
						</div> \
							<div class="retweeted_statues"> \
								<div class="retweeted_statues_text"> \
									<p class="retweeted_status"></p> \
								</div> \
							</div> \
							<div class="th_choose"> \
								<a href="javascript:void(0)" class="repost" id="">转发(<span class="reply" id="span_repost"></span>)</a> \
								<a href="javascript:void(0)" class="comment" id="">评论(<span class="comment" id="span_comment"></span>)</a> \
								<p class="repost">转发说说</p> \
								<p class="comment">评论说说</p> \
							</div> \
									<textarea class="repost_textarea"></textarea> \
									<textarea class="comment_textarea"></textarea> \
								<div class="th_root_button"> \
									<input type="checkbox" class="check_repost"><span class="check_repost">同时转发到树洞</span> \
									<input type="checkbox" class="check_comment"><span class="check_comment">同时评论到此微博</span> \
									<a href="javascript:void(0)" class="post_repost" id=""><img class="post_repost" src="image/sp_button/post-comment.png"></a> \
									<a href="javascript:void(0)" class="post_comment" id=""><img class="post_comment" src="image/sp_button/post-comment.png"></a> \
									<a href="javascript:void(0)" class="post_reply" id=""><img src="image/sp_button/post-comment.png"></a> \
								</div> \
							<div class="comment"></div> \
							<div class="page"></div> \
					</div>');
		$(check_button).click(function(){
			loadweibo();
		});
	});
		function loadweibo(DomIndex,page,index,count){
					$.post('<?php echo base_url();?>index.php/ajax/load',{DomIndex:DomIndex,page:page,index:index,count:count},function(weibo){
						$($('p.post_text').get(weibo.DomIndex)).html(weibo.text);
						if(weibo.img){
							$($('div.root_text').get(weibo.DomIndex)).append('<a href="'+weibo.original_pic+'" id="large_pic" class="large_pic"><img src="'+weibo.img+'" /></a>');
							$('a#large_pic').fancybox();
						}
						$($('span.comment').get(weibo.DomIndex)).html(weibo.cCount);
						$($('span.reply').get(weibo.DomIndex)).html(weibo.rCount);
						$($('a.comment').get(weibo.DomIndex)).attr("id",weibo.mid);
						$($('a.repost').get(weibo.DomIndex)).attr("id",weibo.mid);
						$($('a.post_repost').get(weibo.DomIndex)).attr("id",weibo.mid);
						$($('a.post_comment').get(weibo.DomIndex)).attr("id",weibo.mid);
						$($('a.post_reply').get(weibo.DomIndex)).attr('id',weibo.mid);
						$($('p.retweeted_status').get(weibo.DomIndex)).html(' ');
						$($('p.retweeted_status').get(weibo.DomIndex)).html(weibo.repost);
						if(weibo.repost_img!=null){
							createimg();
						}
						if(weibo.cCount>5){
							createpage(weibo.cCount,DomIndex);
						}
						},"json");				
	}
	</script>
</head>
<body>
	<div class="header">
		<div class="sendbox_wrapper">
			<textarea name="sendbox" id="sendbox" cols="30" rows="10" class="sendbox"></textarea>
			<div class="button" id="button">
				<a href="javascript:void(0);" class="emotion" id="emotion">表情</a>
				<a href="javascript:void(0);" class="send" id="send">发送</a>
			</div>
		</div>
	</div>
	<div class="check_button" id="check_button">
		<h4>往下挖挖看</h4>
	</div>
	<div class="weibo">
		
	</div>
</body>
</html>