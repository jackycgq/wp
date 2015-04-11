<?php
/**
 * Main Template of Tinection WordPress Theme
 *
 * @package   Tinection
 * @version   1.1.0
 * @date      2014.12.10
 * @author    Zhiyan&Unknown <chinash2010@gmail.com>
 * @site      Zhiyanblog <www.zhiyanblog.com>
 * @copyright Copyright (c) 2014-2015, Zhiyan&Unknown
 * @license   http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link      http://www.zhiyanblog.com/tinection.html
**/

?>
<div class="comments-main">
<?php
	if (!empty($_SERVER['SCRIPT_FILENAME']) && 'comments.php' == basename($_SERVER['SCRIPT_FILENAME']))
		die ('请勿直接加载此页。谢谢！');

	if ( post_password_required() ): ?>
		<p class="nocomments"><?php _e('必须输入密码，才能查看评论！','tinection'); ?></p>
	<?php else :
?>
<?php if ('open' == $post->comment_status) : ?>
<div id="respond_box">
	<div style="margin:8px 0 8px 0"><h3 class="multi-border-hl"><span><?php _e('发表评论，标准评论必须符合500字以上才有资格被评选为最佳书评！加油哦！','tinection'); ?></span></h3></div>
	<div id="respond">
		<div class="cancel-comment-reply" style="margin-bottom:5px">

		<small><?php cancel_comment_reply_link(); ?></small>
		</div>
		<?php if ( get_option('comment_registration') && !$user_ID ) : ?>
		<p><div class="comment-notify-login"><span class="comment-login-pop-click user-login" title="<?php _e('登录并评论','tinection'); ?>"><?php _e('[ 登录 ]','tinection'); ?></span><?php _e('才能发表留言！','tinection'); ?></div></p>
	<div class="clear"></div>		
<?php else : ?>
    <form action="<?php echo get_option('siteurl'); ?>/wp-comments-post.php" method="post" id="commentform">
      <?php if ( $user_ID ) : ?>
      <div class="author">
		<div id="real-avatar">
			<?php echo tin_get_avatar( $user_ID , '40' , tin_get_avatar_type($user_ID) ); ?>
		</div>
		<div id="welcome"><a href="<?php echo tin_get_user_url('profile'); ?>"><?php echo $user_identity; ?></a>&nbsp;&nbsp;<a href="<?php echo wp_logout_url(get_permalink()); ?>" title="退出"><?php print __('退出','tinection'); ?></a>
		</div>
	  </div>
	<?php elseif ( '' != $comment_author ): ?>
	<div class="author">
		<div id="real-avatar">
		<?php if(isset($_COOKIE['comment_author_email_'.COOKIEHASH])) : ?>
			<?php $uid = get_user_by_email($comment_author_email)->ID;echo tin_get_avatar($uid, 40, tin_get_avatar_type($uid));?>
		<?php else :?>
			<?php global $user_email;?><?php $uid = get_user_by_email($comment_author_email)->ID;echo tin_get_avatar($uid, 40, tin_get_avatar_type($uid)); ?>
		<?php endif;?>
		</div>
		<div id="welcome"><?php printf(__('欢迎回来 <strong style="color: #f00;">%s</strong>','tinection'), $comment_author); ?>
		<a href="javascript:toggleCommentAuthorInfo();" id="toggle-comment-author-info"><?php _e('更改','tinection'); ?></a></div>
	</div>
			<script type="text/javascript" charset="utf-8">
				var changeMsg = "<?php _e('更改','tinection'); ?>";
				var closeMsg = "<?php _e('隐藏','tinection'); ?>";
				function toggleCommentAuthorInfo() {
					jQuery('#comment-author-info').slideToggle('slow', function(){
						if ( jQuery('#comment-author-info').css('display') == 'none' ) {
						jQuery('#toggle-comment-author-info').text(changeMsg);
						} else {
						jQuery('#toggle-comment-author-info').text(closeMsg);
				}
			});
		}
				jQuery(document).ready(function(){
					jQuery('#comment-author-info').hide();
				});
			</script>

	<?php endif; ?>
	<?php if ( ! $user_ID ): ?>
	<div id="comment-author-info">
		<p class="comment-form-input-info" style="width:30%">
			<label for="author"><?php _e('昵称','tinection'); ?><?php if ($req) _e(' *','tinection'); ?></label>
			<input type="text" name="author" id="author" class="commenttext" value="<?php echo $comment_author; ?>" size="22" tabindex="1" required />
		</p>
		<p class="comment-form-input-info" style="width:35%">
			<label for="email"><?php _e('邮箱','tinection'); ?><?php if ($req) _e (' *','tinection'); ?></label>
			<input type="email" name="email" id="email" class="commenttext" value="<?php echo $comment_author_email; ?>" size="22" tabindex="2" required />
		</p>
		<p class="comment-form-input-info" style="width:35%;padding-right:0">
			<label for="url"><?php _e('网址','tinection'); ?></label>
			<input type="text" name="url" id="url" class="commenttext" value="<?php echo $comment_author_url; ?>" size="22" tabindex="3" />
		</p>
	</div>
      <?php endif; ?>
      <div class="clear"></div>
      <div class="comt-box">
		<textarea name="comment" id="comment" tabindex="5" rows="5" placeholder="<?php _e('说点什么吧，留下您的评语，我们会定期选出最佳评语！','tinection'); ?>" required></textarea>
		<div class="comt-ctrl">
			<button class="submit btn btn-submit" name="submit" type="submit" id="submit" tabindex="6"><i class="fa fa-check-square-o"></i><?php _e(' 提交评论','tinection'); ?></button>
			<!--<input class="reset" name="reset" type="reset" id="reset" tabindex="7" value="<?php /*esc_attr_e( '重　　写','tinection' ); */?>" />-->
			<?php comment_id_fields(); ?>
		</script>
		<?php do_action('comment_form', $post->ID); ?>
		<div class="clr"></div>
        <script type="text/javascript">
        jQuery(function($) {
            //配置
            var comment_input = $( '#commentform textarea' );
            var comment_length = 0;
            // 计算并显示已经输入的字数
            $( '<div class="comment_limit_info">您已输入字数:<span>' +comment_length+　'</span></div>' ).insertAfter( comment_input );
            comment_input.bind( 'keyup', function() {
                // 计算已经输入的字数
                comment_length = $(this).val().length;
                // 显示已经输入的字数
                $( '.comment_limit_info span' ).html( comment_length );
            });
        });
            </script>
		</div>
	   </div>
    </form>
	<div class="clear"></div>
    <?php endif; ?>
	</div>
</div>
<?php endif; ?>
<!-- Comments ad2 -->
		<?php if(!tin_is_mobile()){ ?>
			<div id="cmnt-banner2" class="banner">
			<?php echo ot_get_option('cmntad2');?>
			</div>
		<?php }else{ ?>
			<div id="loopad" class="mobile-ad">
			<?php echo ot_get_option('singlead2_mobile'); ?>
			</div>
		<?php }?>
		<!-- /.Comments ad2 -->
<?php if ($comments) : ?>
	<div class="commenttitle">
        <a href="#normal_comments">
            <span id="comments" class="active"><i class="fa fa-comments-o"></i>
                <?php $count_comments = $wpdb->get_var( $wpdb->prepare( "SELECT COUNT(*) FROM $wpdb->comments  WHERE comment_approved='1' AND comment_post_ID = %d AND length(comment_content) > 200 AND comment_type not in ('trackback','pingback')", $post->ID ) ); echo $count_comments; _e(' 标准评语 ','tinection'); ?>
            </span>
        </a>
        <a href="#quote_comments">
            <span id="comments_quote"><i class="fa fa-comments-o"></i>
                <?php $count_comments = $wpdb->get_var( $wpdb->prepare( "SELECT COUNT(*) FROM $wpdb->comments  WHERE comment_approved='1' AND comment_post_ID = %d AND length(comment_content) <= 200 AND comment_type not in ('trackback','pingback')", $post->ID ) ); echo $count_comments; _e(' 简短小评','tinection'); ?>
            </span>
        </a>
    </div>
	<ol class="commentlist" id="normal_comments">
        <?php wp_list_comments('type=comment&callback=tin_comment&end-callback=tin_end_comment&max_depth=200&reverse_top_level=true'); ?>
        <div class="cpagination"><?php paginate_comments_links('prev_text=«&next_text=»'); ?></div>
	</ol>
	<ol class="commentlist" id="quote_comments">
        <?php wp_list_comments('type=comment&callback=tin_comment_short&end-callback=tin_end_comment_short&max_depth=200&reverse_top_level=true'); ?>
        <div class="cpagination"><?php paginate_comments_links('prev_text=«&next_text=»'); ?></div>
	</ol>

<?php else : ?>
	<?php if ('open' == $post->comment_status) : ?>
	<div class="commenttitle" style="border-bottom:0;"><h3 id="comments" class="multi-border-hl"><span><?php _e('暂无评论','tinection'); ?></span></h3></div>
	 <?php else : ?>
	<div class="commenttitle" style="border-bottom:0;"><h3 class="multi-border-hl"><span><?php _e('评论已关闭','tinection'); ?></span></h3></div>
	<?php endif; ?>
<?php endif; ?>
<?php endif; ?>
</div>