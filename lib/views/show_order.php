<?php
	$Total = 0;
	$SumTotal = 0;	
?>
    <div class="row">
    	
        <h3>Order List</h3>
    	
        <table class="table table-bordered" width="500" border="1">
        	<thead>
            	<tr>
                	<td>Picture</td>
                    <td>Product Name</td>
                    <td>Product Price</td>
                    <td>Qty</td>
                    <td>Total</td>
                    <td align="center">Delete</td>
                </tr>
            </thead>
            <tbody>
            <?php
				$i = 0;
				if( isset($_SESSION["strProductID"]) && !empty($_SESSION["strProductID"]) ):
				  
                foreach($_SESSION["strProductID"] as $pid):
					
					if($pid != ''):
						$product_list = get_product($pid); // get product list from model
						
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
                    <td align="center">
                        <a href="?delete_order&Line=<?php echo $i;?>">
                            <img src="<?php echo 'public/image/recycle_bin.png'; ?>">
                        </a>
                    </td>
                </tr>
                <?php
                		endforeach;
				 	 endif;
					$i++;
				  endforeach;  
				 endif;
				 ?>
            </tbody>
        </table>
       Sum Total <?php echo number_format($SumTotal,2);?>
       <br><br><a href="/">Go to Product</a>
       <?php
		if($SumTotal > 0)
		{
		?>
			| <a href="?checkout">CheckOut</a>
		<?php
			}
		?>
    </div>                            		