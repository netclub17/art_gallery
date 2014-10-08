<?php
# Set to noisy error reporting for development. Comment out later for production mode.
ini_set('display_errors','On');
error_reporting(E_ERROR | E_PARSE);

# Paths
DEFINE("LIB",$_SERVER['DOCUMENT_ROOT']."/lib");
DEFINE("VIEWS",LIB."/views");
DEFINE("PARTIALS",VIEWS."/partials");
DEFINE("IMG_PATH",'public/image');

# Paths to actual files
DEFINE("MODEL",LIB."/model.php");
DEFINE("APP",LIB."/application.php");

# Config email shop
$config_shop_email = 'noppol_y@hotmail.com';
DEFINE('SHOP_CONFIG_EMAIL',$config_shop_email); // constance

# Define a layout
DEFINE("LAYOUT","art");

# This inserts our application code which handles the requests and other things
require APP;

#Global, damn it! Oh well we'll take care of this somehow later on ... stay tuned.
$messages = array();

# Below are all the request handlers written as callbacks

get("/",function(){
   force_to_http("/");
   require MODEL;
   $messages["title"]="Home";
   $messages['page_name'] = 'home';
   $messages['message'] ='Welcome to Art Shop Online !! ';
   $messages['product'] = get_product_all();
   $messages['is_login'] = is_authenticated();
   render($messages,LAYOUT,"home");
});

get("/?signin",function(){
   force_to_https("/?signin");
   require MODEL;
   $messages["title"]="Sign in";
   $messages['page_name'] = 'login';   
   try{
     if(is_authenticated()){
        set_flash("Why on earth do you want to sign in again. You are already signed in. Perhaps you want to sign out first.");
     }
   
   }
   catch(Exception $e){
       set_flash($e->getMessage());
   }
   //For sticky name after redirect from post. This was set in the signin post request. get_session_name returns string or empty string
   $messages['name'] = get_session_message("name");
     
   render($messages,LAYOUT,"login");
});

get("/?signup",function(){
   force_to_https("/?signup");
   require MODEL;
   $messages["title"]="Sign up";
   $messages['page_name'] = 'signup';
   try{
     if(is_authenticated()){
        set_flash("You are already signed in. Why do you want to sign up? Do you want another account? OK then ... who am I to complain!");
     }
   }
   catch(Exception $e){
       set_flash($e->getMessage());
   }
   $messages['name'] = get_session_message("member_name");
   render($messages,LAYOUT,"signup");
});


get("/?finish",function(){
   force_to_https("/?finish");
   require MODEL;
   $messages["title"]="Finish";
   $messages['page_name'] = 'finish';
   try{
     if(is_authenticated()){
        set_flash("We have received information successfully, Thank you. Please visit <a href='/'/>Home Page</a>",'success');
     }
   }
   catch(Exception $e){
       set_flash($e->getMessage());
   }
   render($messages,LAYOUT,"finish_page");
});


get("/?show_order",function(){
	
   session_start();
   
   force_to_https("/?show_order");
   require MODEL;
   $messages["title"]="Show Order";
   $messages['page_name'] = 'show_order';
   try{
     if(is_authenticated()){
        // to do anything
     }else{
	 	redirect_to('/?signin');
	 }
   }
   catch(Exception $e){
       set_flash($e->getMessage());
   }
   render($messages,LAYOUT,"show_order");
});

get("/?checkout",function(){
	
   session_start();
   
   force_to_https("/?checkout");
   require MODEL;
   $messages["title"]="Checkout";
   $messages['page_name'] = 'checkout';
   try{
     if(is_authenticated()){
        // to do anything
     }else{
	 	redirect_to('/?signin');
	 }
   }
   catch(Exception $e){
       set_flash($e->getMessage());
   }
   render($messages,LAYOUT,"checkout");
});

get("/?order&pid=".$_GET['pid'],function(){
	
   force_to_https("/?order&pid=".$_GET['pid']);
   require MODEL;
   $messages["title"]="Show Order";
   $messages['page_name'] = 'show_order';
   try{
     if(is_authenticated()){
        // to do anything
     }
   }
   catch(Exception $e){
       set_flash($e->getMessage());
   }
   render($messages,LAYOUT,"order");
});

get("/?delete_order&Line=".$_GET['Line'],function(){
	
   force_to_https("/?delete_order&Line=".$_GET['Line']);
   require MODEL;
   
   delete_order($_GET['Line']);
   
   $messages["title"]="Show Order";
   $messages['page_name'] = 'show_order';
   try{
     if(is_authenticated()){
        // to do anything
        redirect_to("/?show_order");
     }
   }
   catch(Exception $e){
       set_flash($e->getMessage());
       redirect_to("/?show_order");
   }
   redirect_to("/?show_order");
});


get("/?change",function(){
   force_to_https("/?change");
   $messages["title"]="Change password";
   render($messages,LAYOUT,"change_password");
});


get("/?signout",function(){
   // should this be GET or POST or PUT?????
   force_to_https("/?signout");
   require MODEL;
   if(is_authenticated()){
      try{
         sign_out();
         set_flash("You are now signed out.",'success');
         redirect_to("/");
      }
      catch(Exception $e){
        set_flash("Something wrong with the sessions.");
        redirect_to("/");        
     }
   }
   else{
        set_flash("You can't sign out if you are not signed in!");
        redirect_to("/");
   }  

});


post("/?signup",function(){
  $name = form('name');
  $pw = form('password');
  $confirm_password = form('confirm_password');
  $email = form('email');
  $address = form('address');
  
  if($name && $pw && $confirm_password && $email && $address){
     require MODEL;
     try{
        sign_up($name,$email,$pw,$confirm_password,$address);
        set_flash("Lovely, you are now signed up, ".htmlspecialchars(form('name'))." Now sign in!",'success');    
     }
     catch(Exception $e){
          set_flash($e->getMessage());  
          redirect_to("/?signup");          
     }
  }else{
     set_flash("You are not signed up. Try again and don't leave any fields blank.");  
     redirect_to("/?signup");
  }
  
  redirect_to("/?signin");
});

post("/?signin",function(){
  $name = form('email');
  $password = form('password');
  if($name && $password){
    require MODEL;
    try{
       member_login($name,$password);
    }
    catch(Exception $e){
      set_flash("Could not sign you in. Try again. {$e->getMessage()}");
      
      // Set the name to stick when form next rendered i.e. sticky name
      //set_session_message("member_name",$name);
      
      redirect_to("/?signin");      
    }
  }
  else{
       set_flash("Something wrong with name or password. Try again.");
       redirect_to("/?signin");
  }
  set_flash("Lovely, you are now signed in!",'success');
  redirect_to("/");
});

put("/?change",function(){
  // Not complete of course
  set_flash("Password is changed");
  redirect_to("/");
});


post("/?checkout",function(){
  $name = form('name');
  $email = form('email');
  $address = form('address');
  
  if($name && $email && $address){
     require MODEL;
     try{
        checkout($name,$address,$email);  
     }
     catch(Exception $e){
          set_flash($e->getMessage());  
          redirect_to("/?checkout");          
     }
  }else{
     set_flash("You are not signed up. Try again and don't leave any fields blank.",'success');  
     redirect_to("/?checkout");
  }
  
  redirect_to("/?finish");
});


# The Delete call back is left for you to work out

# This function is automatically run if the scrupt gets this far
error_404(function(){
    header("HTTP/1.0 404 Not Found");
    render($messages,LAYOUT,"404");
}); 
