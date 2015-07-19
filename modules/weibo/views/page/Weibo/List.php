<?php defined('SYSPATH') OR die('No direct access allowed.');
/**
 * 网友写的微博MID转换类
 */
class BaseConvert {

	const raw_map	= "0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz";//base62

	const weibo_map	= "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";//base62 weibo.com

	public static function WeiboEncode($str){
		static $map = self::weibo_map;
		static $base = null;
		if($base === null)
			$base = strlen($map);

		$out = '';
		$len = ceil(strlen($str)/7)*7;
		$str = str_pad($str, $len, '0', STR_PAD_LEFT);
		$list = str_split($str, 7);
		foreach($list as $row){
			if($out){
				$out .= str_pad(self::encode($row, $map, $base), 4, '0', STR_PAD_LEFT);
			}else{
				$out = self::encode($row, $map, $base);
			}
		}
		return $out;
	}

	public static function WeiboDecode($str){
		static $map = null;
		static $base = null;
		if($map === null)
			$map = array_flip(str_split(self::weibo_map));
		if($base === null)
			$base = strlen(self::weibo_map);

		$out = '';
		$len = ceil(strlen($str)/4)*4;
		$str = str_pad($str, $len, '0', STR_PAD_LEFT);
		$list = str_split($str, 4);
		foreach ($list as $row){
			if($out){
				$out .= str_pad(self::decode($row, $map, $base), 7, '0', STR_PAD_LEFT);
			}else{
				$out = self::decode($row, $map, $base);
			}
		}
		return $out;
	}

	public static function encode($str, $map, $base) {
		$out = '';
		do{
			$n = $str%$base;
			$str = floor($str/$base);
			$out = $map[$n] . $out;
		}while ($str);
		return $out;
	}

	public static function decode($str, $map, $base) {
		$out = 0;
		$len = strlen($str);
		for($i=0;$i<$len;$i++){
			$out += $map[$str[$i]] * pow($base, $len-$i-1);
		}
		return $out;
	}

}

?>
<div class="row-fluid">
	<div class="span9">
		<h2><?php echo __('Weibo List') ?></h2>
		<hr />
		<table
			id="admin-weibo-delete-table"
			class="table"
			data-delete-title="<?php echo __('Are you sure to delete this feed and async to weibo.com') ?>"
			data-delete-callback="<?php echo Route::url('weibo-admin', array('controller' => 'Weibo', 'action' => 'delweibo')) ?>"
		>
			<thead>
				<tr>
					<th width="80"><?php echo __('Poster') ?></th>
					<th><?php echo __('Content') ?></th>
					<th width="80"><?php echo __('Actions') ?></th>
				</tr>
			</thead>
			<tbody>
			<?php foreach ($feeds AS $feed): ?>
				<tr<?php if ( ! $feed->mid) { echo ' class="warning"'; } ?>>
					<td><a href="http://weibo.com/<?php echo $feed->user['profile_url'] ?>" rel="popover" href="#" data-img="<?php echo $feed->user['avatar_large'] ?>" target="_blank"><?php echo $feed->user['screen_name'] ?></a></td>
					<td>
						<?php echo $feed->text ?>
						<?php if ($feed->img_id OR $feed->bmiddle_pic): ?>
						<br />
						<img src="<?php echo Media::url($feed->img->filepath ? $feed->img->filepath : $feed->bmiddle_pic) ?>" />
						<?php endif; ?>
					</td>
					<td>
					<?php if ($feed->mid): ?>
						<a class="btn btn-mini btn-info" data-mid="<?php echo $feed->mid ?>" href="http://weibo.com/1660960313/<?php echo BaseConvert::WeiboEncode($feed->mid) ?>" target="_blank"><?php echo __('View') ?></a>
					<?php else: ?>
						<button class="btn btn-mini btn-warning" disabled><?php echo __('View') ?></button>
					<?php endif; ?>
						<a
							href="#"
							id="admin-weibo-delete-item-<?php echo $feed->id ?>"
							class="btn btn-mini btn-danger delete-weibo-btn"
								data-id="<?php echo $feed->id ?>"
						><?php echo __('Delete') ?></a>
					</td>
				</tr>
			<?php endforeach; ?>
			</tbody>
		</table>
		<?php echo $pagination ?>
	</div>
	<?php include Kohana::find_file('views', 'page/weibo/sidebar') ?>
</div>

