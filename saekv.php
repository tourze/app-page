<?php
$username="test";
$password="test";
if (isset($_SERVER['PHP_AUTH_USER']) && $_SERVER['PHP_AUTH_USER']== $username && $_SERVER['PHP_AUTH_PW']==$password) {
?>   
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">   
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>SAE KVDB 第三方管理面板</title>
    </head>

    <body id="nv_forum" class="pg_index" onkeydown="if(event.keyCode==27) return false;">   
    <?php
  $a = isset($_GET['a']) ? $_GET['a']:'';
  $k = isset($_REQUEST['k'])? $_REQUEST['k']:'';
  $v = isset($_POST['v'])? $_POST['v']:'';   
    ?>   
    <div id="header">
  <h3>SAE KVDB 第三方管理面板</h3>
  <p>===========================</p>
  <?php
  $kv = new SaeKV();
  $ret = $kv->init();
  echo "KVDB初始化：".($ret?"成功":"失败(errno:".$kv->errno()." errmsg:".$kv->errmsg().")");
  ?>
  <p>===========================</p>
  <a href="saekv.php?a=set">SET</a> | <a href="saekv.php?a=get">GET</a>  | <a href="saekv.php?a=del">DEL</a>  | <a href="saekv.php?a=allkv">ALL KV</a>  | <a href="saekv.php?a=clear">CLEAR ALL</a>
    </div>   
    <?php
  if($a == 'set'){

      if(!empty($_POST['saekv_key']) && !empty($_POST['saekv_val']) ){
          $_POST['saekv_val'] = stripslashes($_POST['saekv_val']);
          file_put_contents('saekv://'.$_POST['saekv_key'], $_POST['saekv_val']);

          echo "<p>设置成功:{$_POST['saekv_key']} => <pre style=\"margin:5px;border:1px solid #CCC;\">".htmlspecialchars($_POST['saekv_val'])."</pre></p>";
      }else{   
    ?>
          <form action="saekv.php?a=set" name="setform" method="post">
              <p>&nbsp;&nbsp;saekv://<input type="text" name="saekv_key" value="" /></p>
                        <p>Value:<textarea name="saekv_val" cols="60" row="8" ></textarea></p>
              <p>&nbsp;&nbsp;&nbsp;&nbsp;<input type="submit"  value="设置" /></p>
          </form>   
    <?php
      }
  }else if ($a == 'get'){
      ?>
          <form action="saekv.php?a=get" name="setform" method="post">
              <p>&nbsp;&nbsp;saekv://<input type="text" name="k" value="" /></p>
              <p>&nbsp;&nbsp;&nbsp;&nbsp;<input type="submit"  value="获得" /></p>
          </form>

    <?php
      if(!empty($k)){
          $v = file_get_contents('saekv://'.$k);
          if($v){
              echo "<p>取值成功:{$k} => <pre style=\"margin:5px;border:1px solid #CCC;\">".htmlspecialchars($v)."</pre></p>";
          }else{
              echo "<p>{$k}不存在！</p>";
          }

      }       
  }else if($a == 'del'){
      $kv = new SaeKV();

      $ret = $kv->init();
      if(!empty($k) ){
          $v = $kv->delete($k);
          echo "<p>saekv://{$k}删除成功！</p>";

      }else if(!empty($_GET['k'])){
          $v = $kv->delete($_GET['k']);
          echo "<p>saekv://{$_GET['k']}删除成功！</p>";

      }
      else{   
    ?>
          <form action="saekv.php?a=del" name="setform" method="post">
              <p>&nbsp;&nbsp;saekv://<input type="text" name="k" value="" /></p>
              <p>&nbsp;&nbsp;&nbsp;&nbsp;<input type="submit"  value="删除" /></p>
          </form>

    <?php       
      }
	}else if ($a =='allkv'){
      $kv = new SaeKV();

      $ret = $kv->init();
      $ret = $kv->pkrget('', 100);     
      while (true) {                    
          foreach($ret as $k=>$v)
                        echo "<p><a href=\"?a=get&k={$k}\">saekv://{$k}</a> &nbsp;&nbsp;&nbsp;&nbsp; <a href=\"saekv.php?a=del&k={$k}\" onclick=\"return confirm('确认删除？');\" style='color:red;'>DEL</a></p>";
          end($ret);                                
          $start_key = key($ret);
          $i = count($ret);
          if ($i < 100) break;
          $ret = $kv->pkrget('abc', 100, $start_key);
      }

	} else if ($a =='clear'){
      $kv = new SaeKV();

      $ret = $kv->init();
      $ret = $kv->pkrget('', 100);     
      while (true) {
			foreach($ret as $k=>$v)
			{
				$kv->delete($k);
			}
			end($ret);                                
          $start_key = key($ret);
          $i = count($ret);
          if ($i < 100) break;
          $ret = $kv->pkrget('abc', 100, $start_key);
      }
	  ?>CLEAR ALL.<?php
	}
	?>
    </body>
</html>
<?php    
} else{
    header('WWW-Authenticate: Basic realm="Hellotianma Login"');
    header('HTTP/1.1 401 Unauthorized');
    exit();
}
