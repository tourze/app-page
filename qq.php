<?php
$qqdata = file('qq_test.qdb');
foreach ($qqdata AS $row)
{
	@list($qq, $sid) = @explode(',', $row);
	$url = 'http://pt.3g.qq.com/s?aid=nLogin3gqqbysid&3gqqsid=' . $sid;
	echo '<div style="float:left;"><p style="text-align:center;padding:0;margin:0 0 5px 0;">'. $qq .'</p><iframe width="242" height="500" src="' . $url . '"></iframe></div>';
}
