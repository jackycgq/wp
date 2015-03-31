<?php
/**
 * Functions of Tinection WordPress Theme
 *
 * @package   Tinection
 * @version   1.1.4
 * @date      2015.1.26
 * @author    Zhiyan <chinash2010@gmail.com> && Bai Yunshan
 * @site      Zhiyanblog <www.zhiyanblog.com> && Bai Yunshan<http://www.01on.com>
 * @copyright Copyright (c) 2014-2015, Zhiyan && Bai Yunshan
 * @license   http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link      http://www.zhiyanblog.com/tinection.html
**/

?>
<?php
add_filter('content_save_pre', 'Auto_Save_Image_savepost');
function Auto_Save_Image_savepost($content){
	$photo_savepath = 'auto_save_image';
	if(ot_get_option('auto_save_image')==="on"){
		require_once(ABSPATH."/wp-includes/class-snoopy.php");
		$snoopy_Auto_Save_Image = new Snoopy;
		// begin to save pic;
		$img_array = array();
		if ( !empty( $_REQUEST['post_title'] ) )
			$post_title = wp_specialchars( stripslashes( $_REQUEST['post_title'] ));
		$content1 = stripslashes($content);
		if (get_magic_quotes_gpc()) $content1 = stripslashes($content1);
		preg_match_all("/ src=(\"|\'){0,}(http:\/\/(.+?))(\"|\'|\s)/is",$content1,$img_array);
		$img_array = array_unique(dhtmlspecialchars($img_array[2]));
		foreach ($img_array as $key => $value){
			set_time_limit(180); //每个图片最长允许下载时间,秒
			if(str_replace(get_bloginfo('url'),"",$value)==$value&&str_replace(get_bloginfo('url'),"",$value)==$value){
				$fileext = substr(strrchr($value,'.'),1);
				$fileext = strtolower($fileext);
				if($fileext==""||strlen($fileext)>4)$fileext = "jpg";
				$savefiletype = array('jpg','gif','png','bmp');
				if (in_array($fileext, $savefiletype)){ 
					if($snoopy_Auto_Save_Image->fetch($value)){
						$get_file = $snoopy_Auto_Save_Image->results;
					}else{
						echo "error fetching file: ".$snoopy_Auto_Save_Image->error."<br>";
						echo "error url: ".$value;
						die();
					}
					$filetime = time();
					$uploadpath = get_option('upload_path','wp-content/uploads');
					$filepath = "/".$uploadpath."/".$photo_savepath."/".date('Y',$filetime)."/".date('m',$filetime)."/";//图片保存的路径目录
					!is_dir("..".$filepath) ? mkdirs("..".$filepath) : null; 
					$filename = date("His",$filetime).randomname(3);
					$fp = @fopen("..".$filepath.$filename.".".$fileext,"w");
					@fwrite($fp,$get_file);
					fclose($fp);
					//添加数据库记录
					$attachment = array(
						'post_type' => 'attachment',
						'post_mime_type' => $type,
						'guid' => $url,
						'post_parent' => $post_id,
						'post_title' => $title,
						'post_content' => '',
					);
					$id = wp_insert_attachment($attachment, $file, $post_parent);
					if ( !is_wp_error($id) ) {
						//这里会生成缩略图，不要了
						//wp_update_attachment_metadata( $id, wp_generate_attachment_metadata( $id, $file ) );
					}
					$content1 = str_replace($value,get_bloginfo('url').$filepath.$filename.".".$fileext,$content1); //替换文章里面的图片地址
				}
			}
		}
		$content = AddSlashes($content1);
		// end save pic;
	}
	remove_filter('content_save_pre', 'Auto_Save_Image_savepost');
	return $content;
}

function dhtmlspecialchars($string) {
	if(is_array($string)) {
		foreach($string as $key => $val) {
			$string[$key] = dhtmlspecialchars($val);
		}
	}else{
		$string = str_replace('&', '&', $string);
		$string = str_replace('"', '"', $string);
		$string = str_replace('<', '<', $string);
		$string = str_replace('>', '>', $string);
		$string = preg_replace('/&(#\d;)/', '&\1', $string);
	}
	return $string;
}
 
function mkdirs($dir){
	if(!is_dir($dir)){
		mkdirs(dirname($dir));
		mkdir($dir);
	}
	return ;
}
?>