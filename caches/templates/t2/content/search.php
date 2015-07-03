<?php defined('IN_WZ') or exit('No direct script access allowed'); ?><!DOCTYPE html>
<html>
<head lang="zh-CN">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta charset="<?php echo CHARSET;?>">
    <title><?php if(isset($seo_title)) { ?><?php echo $seo_title;?><?php } else { ?><?php echo $siteconfigs['sitename'];?><?php } ?></title>
    <meta name="keywords" content="<?php if(isset($seo_keywords)) { ?><?php echo $seo_keywords;?><?php } ?>">
    <meta name="description" content="<?php if(isset($seo_description)) { ?><?php echo $seo_description;?><?php } ?>">
    <script type="text/javascript" src="<?php echo R;?>t2/js/jquery.min.js"></script>
    <link type="text/css" rel="stylesheet" href="<?php echo R;?>t2/css/bootstrap.css">
    <link type="text/css" rel="stylesheet" href="<?php echo R;?>t2/css/style.css">
    <script type="text/javascript" src="<?php echo R;?>t2/js/bootstrap.js"></script>
    <script type="text/javascript" src="<?php echo R;?>t2/js/wuzhi_searchlist.js"></script>
    <!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
    <script src="<?php echo R;?>haiwaitou/js/ie-emulation-modes-warning.js"></script>
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="http://cdn.bootcss.com/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="http://cdn.bootcss.com/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body>
<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
    <div class="container">
        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
                <li class="dropdown <?php if(!isset($cid)) { ?>active<?php } ?>" id="c0">
                    <a href="<?php echo WEBURL;?>" class="dropdown-toggle">首页</a>
                </li>
                <?php if(defined('IN_ADMIN') && !defined('HTML')) {
	echo "<div class=\"visual_div\" pc_action=\"content\" data=\"\"><a href=\"javascript:void(0)\" class=\"visual_edit\">修改</a>";
}
if(!class_exists('content_template_parse')) {
	$content_template_parse = load_class("content_template_parse", "content");
}
if (method_exists($content_template_parse, 'category')) {
	$rs = $content_template_parse->category(array('order'=>'sort ASC','start'=>'0','pagesize'=>'100','page'=>'0',));
	$pages = $content_template_parse->pages;$number = $content_template_parse->number;}?>
                <?php $n=1;if(is_array($rs)) foreach($rs AS $r) { ?>
                <?php if($r['pid']==0 && $r['ismenu']) { ?>
                <li class="dropdown <?php if($elasticid==$r['cid']) { ?>active<?php } ?>" id="c<?php echo $r['cid'];?>">
                    <a href="<?php echo $r[url];?>" class="dropdown-toggle" data-toggle="dropdown"><?php echo $r['name'];?><span class="caret"></span></a>
                    <ul class="dropdown-menu" role="menu">
                        <?php $n=1;if(is_array($rs)) foreach($rs AS $rn) { ?>
                        <?php if($rn['pid']==$r['cid']) { ?><li><a href="<?php echo $rn[url];?>"><?php echo $rn['name'];?></a></li><?php } ?>
                        <?php $n++;}?>
                    </ul>
                </li>
                <?php } ?>
                <?php $n++;}?>
                <?php if(defined('IN_ADMIN') && !defined('HTML')) {echo '</div>';}?>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <li><a href="<?php echo WEBURL;?>index.php?m=member&v=register">注册</a></li>
                <li><a href="<?php echo WEBURL;?>index.php?m=member&v=login">登录</a></li>
            </ul>
        </div>
        <!-- /.navbar-collapse -->
    </div>
    <!-- /.container-fluid -->
</nav>

<div class="top_box">
  <div class="container">
    <div class="top_logo"><img src="<?php echo R;?>t2/image/logo.png" height="63"></div>
    <div class="wuzhi_search_top">
        <form class="navbar-form" role="search" method="get" action="<?php echo WEBURL;?>index.php?f=search">
            <input name="f" value="search" type="hidden">
            <div class="form-group">
          <input type="text" name="keywords" class="form-control" size="65" value="<?php echo $keywords;?>" placeholder="输入您要搜索的内容">
        </div>
        <button type="submit" class="btn btn-primary_g">&nbsp;&nbsp;&nbsp;&nbsp;搜索&nbsp;&nbsp;&nbsp;&nbsp;</button>
      </form>
      <p>获得约<span style="color:#C00"> <?php echo $total_number;?> </span>条结果 （用时<?php echo $runtime;?> 秒）</p>
    </div>
  </div>
</div>

<div class="bankuai_1">
  <div class="container">
    <div class="row">
      <div class="col-xs-2">
		<div class="wuzhi_search_list" id="wuzhi_searchlist">
          <h5 style=" text-align:right">按时间搜索结果</h5>
          <div class="list-group" style="text-align:right">
            <a href="?f=search&starttime=0&keywords=<?php echo $keywords;?>" class="list-group-item_gr <?php if($starttime==0) { ?>active<?php } ?>">全部时间</a>
            <a href="?f=search&starttime=1&keywords=<?php echo $keywords;?>" class="list-group-item_gr <?php if($starttime==1) { ?>active<?php } ?>" >一天内</a>
            <a href="?f=search&starttime=7&keywords=<?php echo $keywords;?>" class="list-group-item_gr <?php if($starttime==7) { ?>active<?php } ?>">一周内</a>
            <a href="?f=search&starttime=30&keywords=<?php echo $keywords;?>" class="list-group-item_gr <?php if($starttime==30) { ?>active<?php } ?>">一月内</a>
            <a href="?f=search&starttime=365&keywords=<?php echo $keywords;?>" class="list-group-item_gr <?php if($starttime==365) { ?>active<?php } ?>">一年内</a>
          </div>
          <h5 style=" text-align:right">搜索历史</h5>
          <div class="list-group" style="text-align:right">
           <?php $n=1;if(is_array($history_result)) foreach($history_result AS $rs) { ?>
            <a href="?f=search&starttime=0&keywords=<?php echo $rs;?>" class="list-group-item_gr"><?php echo $rs;?></a>
           <?php $n++;}?>
          </div>
        </div>
      </div>
      <div class="col-xs-10" style="border-left:1px solid #ddd">
        <div class="wuzhi_search_bd">
<?php $n=1;if(is_array($result)) foreach($result AS $r) { ?>
        	<div class="wuzhi_search_bdlist">
            <div class="Nhead"><a href="<?php echo $r['url'];?>" ><?php echo str_replace($keywords, "<font color='#C00'>".$keywords."</font>", $r['title']);?></a></div>
            <div class="Nbd"><?php if($r['thumb']) { ?><a href="<?php echo $r['url'];?>"><img src="<?php echo $r['thumb'];?>"></a><?php } ?>
                <p><?php echo str_replace($keywords, "<font color='#C00'>".$keywords."</font>", strcut($r['remark'],160));?></p>
              </div>
            <div class="Nfoot">
                <div class="lwd">发布时间：<?php echo date('Y年m月d日 H:i',$r['addtime']);?></div>
              </div>
          </div>
<?php $n++;}?>
		<nav>
          <ul class="pagination">
              <li><a>共<?php echo $total_number;?>条</a></li>
            <?php echo $result_pages;?>
          </ul>
        </nav>
        </div>
        
      </div>
    </div>
  </div>
</div>
<?php if(!isset($siteconfigs)) $siteconfigs=get_cache('siteconfigs'); include T("content","foot",TPLID); ?>
