	    <div class="content">
		
	            <form class="form-horizontal group-border-dashed" action="?signin" method="post" style="border-radius: 0px;">
	            <input type='hidden' name='_method' value='post' />
	            <h3>Login Member</h3>
             	<div style="clear:both; margin-bottom: 20px;"></div>
	            
	              <div class="form-group">
	                <label class="col-sm-3 control-label">Email</label>
	                <div class="col-sm-6">
	                   <input name="email" type="text" value="<?php echo $email = isset($_POST['email']) && !empty($_POST['email']) ? $_POST['email'] :''; ?>" class="form-control" id="inputEmail" placeholder="Email">
	                </div>
	              </div>
	              <div class="form-group">
	                <label class="col-sm-3 control-label">Password</label>
	                <div class="col-sm-6">
	                  <input name="password" type="password" class="form-control" id="inputPassword" placeholder="Password" value="<?php echo $password = isset($_POST['password']) && !empty($_POST['password']) ? $_POST['password'] :''; ?>">
	                </div>
	              </div>
	              <label class="col-sm-3 control-label"></label>
	              <div class="col-sm-6" style="padding-left: 7px;">
	              	<button type="submit" class="btn btn-primary">Login</button>
	              </div>
	            </form>
          </div>

  

                             		