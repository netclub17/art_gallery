<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title><?php echo 'Art Shop Online > '.$title; ?></title>
<link rel="stylesheet" href="public/css/bootstrap/bootstrap.min.css">
<link rel="stylesheet" href="public/css/bootstrap/bootstrap-theme.css">
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script> 
<style type="text/css">
    body{
    	padding-top: 70px;
    }
</style></head>
<body>
	<!-- top menu -->
	<nav id="myNavbar" class="navbar navbar-default navbar-inverse navbar-fixed-top" role="navigation">
		<!-- Brand and toggle get grouped for better mobile display -->
		<div class="container">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbarCollapse">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" style="color:#FFFFFF;" href="/">Art Shop Online</a>
			</div>
			<!-- Collect the nav links, forms, and other content for toggling -->   
			<div class="collapse navbar-collapse" id="navbarCollapse">
				<ul class="nav navbar-nav">
					<li <?php if($page_name =='home'){ echo 'class="active"'; } ?>><a href="/">Home</a></li>
					<?php if( ! isset($_SESSION['member_name']) && empty($_SESSION['member_name']) ): ?>
						<li <?php if($page_name =='signup'){ echo 'class="active"'; } ?> ><a href="?signup">Sign up</a></li>
						<li <?php if($page_name =='login'){ echo 'class="active"'; } ?>><a href="?signin">Login</a></li>
					<?php else: ?>
                    	<li <?php if($page_name =='show_order'){ echo 'class="active"'; }?>><a href="<?php echo '?show_order'; ?>" target="_self">My Shopping Cart</a></li>
                	<?php endif; ?>	
				</ul>
			</div>     
		</div>
	</nav>
<div style="float:right; margin-right: 10px;">
	<?php 
		if( isset($_SESSION['member_name']) && !empty($_SESSION['member_name']) )
		{
			echo '<span style="font-weight:bold;">'.$_SESSION['member_name'].'</span>';
	?>		
		| <a href="?signout">Logout</a>
	<?php		
		}
	?>
</div>
<div style="clear: both; margin-bottom: 10px;"></div><!-- end top menu -->

<div class="container">	 	
       <?php
		  if(!empty($flash)){
			echo "{$flash}";
		  }
		  require VIEWS."/{$content}.php";
		?>           
</div>
</body>
</html>                                		