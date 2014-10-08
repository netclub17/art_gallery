<?php
		$Total = 0;
  		$SumTotal = 0;
?>
    <div class="row">
    	
        <h3>Checkout</h3>
    	
        <table class="table table-bordered" width="500" border="1">
        	<thead>
            	<tr>
                	<td>Picture</td>
                    <td>Product Name</td>
                    <td>Product Price</td>
                    <td>Qty</td>
                    <td>Total</td>
                </tr>
            </thead>
            <tbody>
            	<?php
                 for($i=0;$i<=(int)$_SESSION["intLine"];$i++):
					
					if($_SESSION["strProductID"][$i] != ''):;
						
						$product_list = get_product($_SESSION["strProductID"][$i]); // get product list from model
						
						foreach($product_list as $info):
						
						$Total = $_SESSION["strQty"][$i] * $info->Price;
						$SumTotal = $SumTotal + $Total;
				?>
            	<tr>
                	<td style="width: 284px;"><img style="width: 284px;height: 177px;" src="<?php echo IMG_PATH.'/'.$info->Picture; ?>"></td>
                    <td><?php echo $info->ProductName; ?></td>
                    <td><?php echo $info->Price; ?></td>
                    <td><?php echo $_SESSION["strQty"][$i]; ?></td>
                    <td><?php echo number_format($Total,2); ?></td>
                </tr>
                <?php
                		endforeach; 
				 	endif;
				 endfor;
				 ?>
            </tbody>
        </table>
       Sum Total <?php echo number_format($SumTotal,2);?>
    </div>
    
    <div class="content">
		
             <form class="form-horizontal group-border-dashed" action="?checkout" method="post" style="border-radius: 0px; margin-top: 20px;">
             <input type='hidden' name='_method' value='post' />
             <h4>Checkout Detail</h4>
             <div style="clear:both; margin-bottom: 20px;"></div>
             	
              <div class="form-group">
                <label class="col-sm-3 control-label">Name</label>
                <div class="col-sm-6">
                  <input name="name" type="text" class="form-control" id="inputEmail" placeholder="Name" value="<?php echo $name = isset($_SESSION['member_name']) && !empty($_SESSION['member_name']) ? $_SESSION['member_name'] :''; ?>">
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-3 control-label">Address</label>
                <div class="col-sm-6">
                  <textarea name="address" class="form-control" rows="5"><?php echo $address = isset($_SESSION['member_address']) && !empty($_SESSION['member_address']) ? $_SESSION['member_address'] :''; ?></textarea>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-3 control-label">Email</label>
                <div class="col-sm-6">
                   <input name="email" type="text" value="<?php echo $email = isset($_SESSION['member_email']) && !empty($_SESSION['member_email']) ? $_SESSION['member_email'] :''; ?>" class="form-control" id="inputEmail" placeholder="Email">
                </div>
              </div>
              <label class="col-sm-3 control-label"></label>
              <div class="col-sm-6" style="padding-left: 7px;">
              	<button type="submit" class="btn btn-primary">Submit</button>
              </div>
            </form>
          </div>                        		