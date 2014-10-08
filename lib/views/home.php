<div class="row">
	<h3>Product</h3>
	<div style="margin-bottom: 20px;">
	 	<marquee behavior="scroll" direction="left"><?php echo $message; ?></marquee>
	</div>
	<?php foreach ($product as $key => $data_info): ?>
		<div class="col-sm-6 col-md-4 col-lg-3">
	        <h4><?php echo $data_info->ProductName; ?></h4>
	        <img style="width: 284px;height: 177px;" src="<?php echo IMG_PATH.'/'.$data_info->Picture; ?>"><br>
	        <p style="margin-top:10px;">Price : <?php echo $data_info->Price; ?></p>
	        <p style="margin-top:20px;">
	        	<?php $link = $is_login == false ? '?signin' : '?order&pid='.$data_info->ProductID; ?>
	        	<a href="<?php echo $link;?>" class="btn btn-success">Order Now</a>
	        </p>
	    </div>
	<?php endforeach; ?>
</div>