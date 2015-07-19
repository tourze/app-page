<?php

class Controller_QRCode extends Controller {

	public function action_test()
	{
		echo "<h1>PHP QR Code</h1><hr/>";
		
		//set it to writable location, a place for temp generated PNG files
		$PNG_TEMP_DIR = DOCROOT . 'media/temp/';
		
		//html PNG location prefix
		$PNG_WEB_DIR = '/media/temp/';

		//ofcourse we need rights to create temp dir
		if (!file_exists($PNG_TEMP_DIR))
			mkdir($PNG_TEMP_DIR);
		
		
		$filename = $PNG_TEMP_DIR.'test.png';
		
		//processing form input
		//remember to sanitize user input in real-life solution !!!
		$errorCorrectionLevel = 'L';
		if (isset($_REQUEST['level']) && in_array($_REQUEST['level'], array('L','M','Q','H')))
			$errorCorrectionLevel = $_REQUEST['level'];    

		$matrixPointSize = 4;
		if (isset($_REQUEST['size']))
			$matrixPointSize = min(max((int)$_REQUEST['size'], 1), 10);

		$layout = '';
		if (isset($_REQUEST['layout']))
		{
			$layout = $_REQUEST['layout'];
		}
		
		$layout_x = 10;
		if (isset($_REQUEST['layout_x']))
		{
			$layout_x = $_REQUEST['layout_x'];
		}
		
		$layout_y = 10;
		if (isset($_REQUEST['layout_y']))
		{
			$layout_y = $_REQUEST['layout_y'];
		}

		if (isset($_REQUEST['data'])) { 
		
			//it's very important!
			if (trim($_REQUEST['data']) == '')
				die('data cannot be empty! <a href="?">back</a>');
			
			// user data
			$filename = $PNG_TEMP_DIR.'test'.md5($_REQUEST['data'].'|'.$errorCorrectionLevel.'|'.$matrixPointSize).'.png';
			QRcode::png($_REQUEST['data'], $filename, $errorCorrectionLevel, $matrixPointSize, 2);
			
			if ($layout)
			{
				$point_size_padding = 3;
				
				// 先打开背景图片
				$layout_image = imagecreatefromjpeg($layout);
				imagesavealpha($layout_image, true);
				echo "<pre>";
				$text = QRcode::text($_REQUEST['data'], false, $errorCorrectionLevel);
				$length = count($text);
				
				// 先直接覆盖一个大块
				$dot = imagecolorallocatealpha($layout_image, 255, 255, 255, 70);

				$new_x = $layout_x - $matrixPointSize;
				$new_y = $layout_y - $matrixPointSize;
				$loc_x = $new_x + $matrixPointSize * 9 - 1;
				$loc_y = $new_y + $matrixPointSize * 9 - 1;
				imagefilledrectangle($layout_image, $new_x, $new_y, $loc_x, $loc_y, $dot);
				
				$new_x = $layout_x + ($length - 8) * $matrixPointSize;
				$new_y = $layout_y - $matrixPointSize;
				$loc_x = $new_x + $matrixPointSize * 9 - 1;
				$loc_y = $new_y + $matrixPointSize * 9 - 1;
				imagefilledrectangle($layout_image, $new_x, $new_y, $loc_x, $loc_y, $dot);
				
				$new_x = $layout_x - $matrixPointSize;
				$new_y = $layout_y + ($length - 8) * $matrixPointSize;
				$loc_x = $new_x + $matrixPointSize * 9 - 1;
				$loc_y = $new_y + $matrixPointSize * 9 - 1;
				imagefilledrectangle($layout_image, $new_x, $new_y, $loc_x, $loc_y, $dot);
				
				foreach ($text AS $y => $line)
				{
					//$line = bin2hex($line);
					$line = str_split($line, 1);
					foreach ($line AS $x => $dot)
					{
						$dot = (int) $dot;
						// 如果dot为1，那么就需要绘制
						
						// 标志点内
						if (
							($x <= 7 && $y <= 7)
							OR ($x <= 7 && $y >= ($length - 8))
							OR ($x >= ($length - 8) && $y <= 7)
						)
						{
							if ($dot)
							{
								// 分配一个黑点
								$dot = imagecolorallocatealpha($layout_image, 0, 0, 0, 40);
								$new_x = $layout_x + $x * $matrixPointSize;
								$new_y = $layout_y + $y * $matrixPointSize;
								$loc_x = $new_x + $matrixPointSize - 1;
								$loc_y = $new_y + $matrixPointSize - 1;
								imagefilledrectangle($layout_image, $new_x, $new_y, $loc_x, $loc_y, $dot);
							}
						}
						// 标志点外
						else
						{
							if ($dot)
							{
								//echo "$x $y\n";
								// 先分配一个透明度较高的点
								$dot = imagecolorallocatealpha($layout_image, 0, 0, 0, 80);
								$new_x = $layout_x + $x * $matrixPointSize;
								$new_y = $layout_y + $y * $matrixPointSize;
								$loc_x = $new_x + $matrixPointSize - 1;
								$loc_y = $new_y + $matrixPointSize - 1;
								imagefilledrectangle($layout_image, $new_x, $new_y, $loc_x, $loc_y, $dot);
									
								// 再分配一个透明度较低的点
								$dot = imagecolorallocatealpha($layout_image, 0, 0, 0, 70);
								$new_x = $new_x + $point_size_padding;
								$new_y = $new_y + $point_size_padding;
								$loc_x = $loc_x - $point_size_padding;
								$loc_y = $loc_y - $point_size_padding;
								imagefilledrectangle($layout_image, $new_x, $new_y, $loc_x, $loc_y, $dot);
							}
							else
							{
								//echo "$x $y\n";
								// 先分配一个透明度较高的点
								//$dot = imagecolorallocatealpha($layout_image, 255, 255, 255, 80);
								$new_x = $layout_x + $x * $matrixPointSize;
								$new_y = $layout_y + $y * $matrixPointSize;
								$loc_x = $new_x + $matrixPointSize - 1;
								$loc_y = $new_y + $matrixPointSize - 1;
								//imagefilledrectangle($layout_image, $new_x, $new_y, $loc_x, $loc_y, $dot);
									
								// 再分配一个透明度较低的点
								$dot = imagecolorallocatealpha($layout_image, 255, 255, 255, 70);
								$new_x = $new_x + $point_size_padding;
								$new_y = $new_y + $point_size_padding;
								$loc_x = $loc_x - $point_size_padding;
								$loc_y = $loc_y - $point_size_padding;
								imagefilledrectangle($layout_image, $new_x, $new_y, $loc_x, $loc_y, $dot);
							}
						}
					}
					//echo "\n";
				}
				imagepng($layout_image, $filename);
				echo "</pre>";
			}

		} else {    
		
			//default data
			echo 'You can provide data in GET parameter: <a href="?data=like_that">like that</a><hr/>';    
			QRcode::png('PHP QR Code :)', $filename, $errorCorrectionLevel, $matrixPointSize, 2);    
			
		}    
			
		//display generated file
		echo '<img src="'.$PNG_WEB_DIR.basename($filename).'" /><hr/>';  
		
		//config form
		echo '<form action="" method="post">
			Data:&nbsp;<input name="data" value="'.(isset($_REQUEST['data'])?htmlspecialchars($_REQUEST['data']):'BLSBLS').'" />&nbsp;
			ECC:&nbsp;<select name="level">
				<option value="L"'.(($errorCorrectionLevel=='L')?' selected':'').'>L - smallest</option>
				<option value="M"'.(($errorCorrectionLevel=='M')?' selected':'').'>M</option>
				<option value="Q"'.(($errorCorrectionLevel=='Q')?' selected':'').'>Q</option>
				<option value="H"'.(($errorCorrectionLevel=='H')?' selected':'').'>H - best</option>
			</select>&nbsp;
			Size:&nbsp;<select name="size">';
		for($i=1;$i<=10;$i++)
			echo '<option value="'.$i.'"'.(($matrixPointSize==$i)?' selected':'').'>'.$i.'</option>';
			
		echo '</select>&nbsp;
		
		<input name="" />
		<br/>
		<br/>
		Layout:<input type="text" name="layout" value="'.$layout.'" />
		&nbsp;X:<input type="text" name="layout_x" value="'.$layout_x.'" />
		&nsbp;Y:<input type="text" name="layout_y" value="'.$layout_y.'" />
		<br/>
		<br/>
			<input type="submit" value="GENERATE"></form><hr/>';
			
		// benchmark
		QRtools::timeBenchmark();
	}

}
