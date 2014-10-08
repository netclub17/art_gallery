<div class="content">	
     <form class="form-horizontal group-border-dashed" action="?signup" method="post" style="border-radius: 0px; margin-top: 20px;">
     	
     <h3>Sign up</h3>
     <div style="clear:both; margin-bottom: 20px;"></div>
     	<input type='hidden' name='_method' value='post' />
     	
      <div class="form-group">
        <label class="col-sm-3 control-label">Name</label>
        <div class="col-sm-6">
          <input name="name" type="text" class="form-control" id="inputEmail" placeholder="Name" value="<?php echo $name = isset($_POST['name']) && !empty($_POST['name']) ? $_POST['name'] :''; ?>">
        </div>
      </div>
      <div class="form-group">
        <label class="col-sm-3 control-label">Address</label>
        <div class="col-sm-6">
          <textarea name="address" class="form-control" rows="5"><?php echo $address = isset($_POST['address']) && !empty($_POST['address']) ? $_POST['address'] :''; ?></textarea>
        </div>
      </div>
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
        <div class="form-group">
        <label class="col-sm-3 control-label">Confirm Password</label>
        <div class="col-sm-6">
          <input name="confirm_password" type="password" class="form-control" id="inputPassword" placeholder="Password" value="<?php echo $password = isset($_POST['password']) && !empty($_POST['password']) ? $_POST['password'] :''; ?>">
        </div>
      </div>
      <label class="col-sm-3 control-label"></label>
      <div class="col-sm-6" style="padding-left: 7px;">
      	<button type="submit" class="btn btn-primary">Submit</button>
      </div>
    </form>
 </div>