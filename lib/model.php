<?php

function get_db(){
    $db = null;

    try{
        $db = new PDO('mysql:host=localhost;dbname=art_db;charset=utf8', 'root','123456');
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
    catch(PDOException $e){
        // notice how we THROW the exception. You can catch this in your controller code in the usual way
        throw new Exception("Something wrong with the database: ".$e->getMessage());
    }
    return $db;

}

/* Other functions can go below here */

function sign_up( $name, $email, $password, $confirm_password , $address){
   try{
         $db = get_db();
	     if(validate_user_name($db,$email) && validate_passwords($password,$confirm_password)){
	          $salt = generate_salt();
	          $password_hash = generate_password_hash($password,$salt);		 
	          $query = "INSERT INTO member (name,email,salt,password,address,datecreate,status) VALUES (?,?,?,?,?,?,?)";

	          if($statement = $db->prepare($query)){
	             $binding = array($name,$email,$salt,$password_hash,$address,date('Y-m-d H:i:s'),1);
	             if(!$statement -> execute($binding)){
	                 throw new Exception("Could not execute query.");
	             }
	          }
	          else{
	            throw new Exception("Could not prepare statement.");

	          }
	     }
	     else{
	        throw new Exception("Invalid data.");
	     }
   }
   catch(Exception $e){
       throw new Exception($e->getMessage());
   }

}

function checkout( $name, $address , $email ){
   try{
        $db = get_db();
        
        session_start();
        
     //if(validate_user_name($db,$email) && validate_passwords($password)){ 
     	if( ! empty($name) && !empty($address) && !empty($email) ):
     	
          $query = "INSERT INTO orders (OrderDate,Name,Address,Email) VALUES (?,?,?,?)";
		 
          if($statement = $db->prepare($query)){
          	 
             $binding = array( date('Y-m-d H:i:s'),$name ,$address,$email);
    
             if(!$statement -> execute($binding)){
                 throw new Exception("Could not execute query.");
             }
             $order_id = $db->lastInsertId();
             $order_id =  str_pad((int) $order_id,5,"0",STR_PAD_LEFT);
             
             
             if( isset($_SESSION["intLine"]) && ! empty($_SESSION["intLine"]) )
			 {
	          	for($i=0;$i<=(int)$_SESSION["intLine"];$i++)
	  			{
				  if( $_SESSION["strProductID"][$i] != "" )
				  {
					  $query = "INSERT INTO orders_detail (OrderID,ProductID,Qty) VALUES (?,?,?)";
					 
					   if($statement = $db->prepare($query)){
			          	 
			             $binding = array( $order_id ,$_SESSION["strProductID"][$i] ,$_SESSION["strQty"][$i]);
			             
			             if( ! $statement -> execute($binding) ){
			                 throw new Exception("Could not execute query.");
			             }
			          }
			          else{
			            throw new Exception("Could not prepare statement.");

			          }
			            	  
				  }
				}
	         } 
                  
          }
          else{
            throw new Exception("Could not prepare statement.");

          }
          
       // send email to shop   
       $send_email = send_email($email,$name,$address);
        
       unset($_SESSION['intLine'],$_SESSION['strProductID'],$_SESSION['strQty']);
        
          
       endif;   
     /*}
     else{
        throw new Exception("Invalid data.");
     }*/
     

   }
   catch(Exception $e){
       throw new Exception($e->getMessage());
   }

}

function member_login($email,$password){
   try{
      $db = get_db();  
      $query = "SELECT id ,name, email, address ,salt, password FROM member WHERE email=?";
      if($statement = $db->prepare($query)){
         $binding = array($email);
         if(!$statement -> execute($binding)){
                 throw new Exception("Could not execute query.");
         }
         else{
            $result = $statement->fetch(PDO::FETCH_ASSOC);
            $salt = $result['salt'];
            $hashed_password = $result['password'];
            $email = $result['email'];
            $address = $result['address'];
            if(generate_password_hash($password,$salt) !== $hashed_password){
                throw new Exception("Account does not exist!");
            }
            else{
               $id = $result["id"];
			  // set_session_message('member_name',$result['name']);
			   //set_session_message('id',$id);
               set_authenticated_session($id,$hashed_password,$result['name'],$email,$address);
            }
         }
      }
      else{
            throw new Exception("Could not prepare statement.");
      }

   }
   catch(Exception $e){
      throw new Exception($e->getMessage());
   }
}

function set_authenticated_session($id,$password_hash,$member_name,$member_email,$member_address){
      session_start();  
      
      //Make it a bit harder to session hijack
      session_regenerate_id(true);

      $_SESSION["id"] = $id;
      $_SESSION["hash"] = $password_hash;
      $_SESSION['member_name'] = $member_name;
      $_SESSION['member_email'] = $member_email;
      $_SESSION['member_address'] = $member_address;
      session_write_close();
}

function check_order(){
	
	session_start();
	
	//Make it a bit harder to session hijack
     session_regenerate_id(true);
	
	if(!isset($_SESSION["intLine"]))
	{
		 $_SESSION["intLine"] = 0;
		 $_SESSION["strProductID"][0] = $_GET["pid"];
		 $_SESSION["strQty"][0] = 1;	
	}else{
		$key = array_search($_GET["pid"], $_SESSION["strProductID"]);
		if((string)$key != "")
		{
			 $_SESSION["strQty"][$key] = $_SESSION["strQty"][$key] + 1;
		}
		else
		{
			 $_SESSION["intLine"] = $_SESSION["intLine"] + 1;
			 $intNewLine = $_SESSION["intLine"];
			 $_SESSION["strProductID"][$intNewLine] = $_GET["pid"];
			 $_SESSION["strQty"][$intNewLine] = 1;
		}
	}
	
	force_to_http('/?show_order');
}


function generate_password_hash($password,$salt){
      return hash("sha256", $password.$salt, false);
}

function generate_salt(){
    $chars = "0123456789ABCDEF";
    return str_shuffle($chars);
}

function validate_user_name($db,$user_name){

  if(!empty($user_name)){
     if($result=filter_var($user_name,FILTER_VALIDATE_EMAIL)){
	    return true;
	 }
	 
  }
    // is it a valid name?
    // use get_user_id function. if empty then it doesn't exist
    // if all good return true, other return false
    return false;
}

function validate_passwords($password, $password_confirm){
   if($password === $password_confirm ){
      return true;
   }
   return false;
}

function validate_password($password){

$regrex ='~^[A-Z]{1}[a-z0-9]{7,}+$~';

 if( ! empty($password) && preg_match($regrex,$password)){
      return true;
   }
   return false;
}



function is_authenticated(){
    $id = "";
    $hash="";
    
    session_start();
    if(!empty($_SESSION["id"]) && !empty($_SESSION["hash"])){
       $id = $_SESSION["id"];
       $hash = $_SESSION["hash"];
    }
    session_write_close();
 
    if(!empty($id) && !empty($hash)){

        try{
           $db = get_db();
           $query = "SELECT name, password FROM member WHERE id=?";
           if($statement = $db->prepare($query)){
             $binding = array($id);
             if(!$statement -> execute($binding)){
              	return false;
             }
             else{
                 $result = $statement->fetch(PDO::FETCH_ASSOC);
                 if($result['password'] === $hash){
                   return true;
                 }
             }
           }
            
        }
        catch(Exception $e){
           throw new Exception("Authentication not working properly. {$e->getMessage()}");
        }
    
    }
    return false;

}

function sign_out(){
    session_start();
    if(!empty($_SESSION["id"]) && !empty($_SESSION["hash"])){
       $_SESSION["id"] = "";
       $_SESSION["hash"] = ""; 
	   $_SESSION['member_name'] ='';
       $_SESSION = array();
       session_destroy();                     
    }
    session_write_close();
}


function get_product_all(){
	
	$result ='';	
	try{
		$db = get_db();
		$query = "SELECT * FROM product";
		if($statement = $db->prepare($query) ){
             if( ! $statement->execute() ){
                 throw new Exception("Could not execute query.");
             }
             else{
             	 $result = $statement->fetchAll(PDO::FETCH_OBJ);
             }
		}
		else{
            throw new Exception("Could not prepare statement.");
        }
	}
	catch(Exception $e){
           throw new Exception($e->getMessage());
    }	
	return $result;
}

function get_product($pid){

	$result = array();
	
	try{
		$db = get_db();
		$query = "SELECT * FROM product WHERE ProductID =?";
		if( $statement = $db->prepare($query) ){
			$binding = array($pid);
			 if( ! $statement->execute($binding) ){
                 throw new Exception("Could not execute query.");
             }
             else{
             	 $result = $statement->fetchAll(PDO::FETCH_OBJ);		 
             }
		
		}else{
            throw new Exception("Could not prepare statement.");
        }
	}
	catch(Exception $e)
	{
		throw new Exception($e->getMessage());
	}

	return $result;
}

function delete_order($Line)
{
	session_start();
	
	$_SESSION["strProductID"][$Line] = "";
	$_SESSION["strQty"][$Line] = "";
}

function send_email($email,$name,$address)
{
	if( empty($email) ){ return false; }
	
	require LIB.'/phpmailer/class.phpmailer.php';
	
	if( !empty($email) )
	{
		$mail             = new PHPMailer();
		$mail->CharSet    = 'UTF-8'; // set encoding is UTF-8.
		$body			  = get_email_content($name,$address);
		$mail->IsSMTP(); 							// telling the class to use SMTP
		$mail->SMTPAuth   = true;                  // enable SMTP authentication
		$mail->SMTPSecure = 'ssl'; // secure transfer enabled REQUIRED for GMail
		$mail->Host = 'smtp.gmail.com';
		$mail->Port = 465;
		$mail->Username   = "developertesting79@gmail.com";  // GMAIL username
		$mail->Password   = "Developer123456";            // GMAIL password
		$email_from = 'developertesting79@gmail.com'; 
		$from_name = 'Developer2014';
		$mail->SetFrom( $email_from , $from_name );
		$mail->Subject  = 'contact by '.$name;
		$mail->MsgHTML($body);

		$mail->AddAddress($email);
		$mail->AddAddress(SHOP_CONFIG_EMAIL); // config email shop
		
		if( ! @$mail->Send() ) 
		{
			return false;
		} 
		else 
		{
			return true;
		}
	
	}
	
}

function get_email_content($name,$address)
{
	
	$Total = 0;
  	$SumTotal = 0;
	
	$content  = '<h3>Contact Art shop online</h3>';
	$content .= '<h4>Product Detail</h4>';
	$content .= '<table class="table table-bordered" style="backgrond-color:#ccc;color:#ffffff font-weight:bold;" width="500" border="1">';
	$content .= '<thead>';
	$content .= '<tr>';
	$content .= '<td>Product Name</td>';
	$content .= '<td>Product Price</td>';
	$content .= '<td>Qty</td>';
	$content .= '<td>Total</td>';
	$content .= '</tr>';
	$content .= '</thead>';
	$content .= '<tbody>';
		 $i = 0;
		 for($i=0;$i<=(int)$_SESSION["intLine"];$i++) {
			
			if($_SESSION["strProductID"][$i] != '')
			{
				
				$product_list = get_product($_SESSION["strProductID"][$i]); // get product list
				foreach($product_list as $row){

				$Total = $_SESSION["strQty"][$i] * $row->Price;
				$SumTotal = $SumTotal + $Total;
	$content .= '<tr>';
	$content .= '<td>'.$row->ProductName.'</td>';
	$content .= '<td>'.$row->Price.'</td>';
	$content .= '<td>'.$_SESSION["strQty"][$i].'</td>';
	$content .= '<td>'.number_format($Total,2).'</td>';
	$content .= '</tr>';
	
				}
	
			  }
		   }		 
	$content .= '</tbody>';
	$content .= '</table>';
	$content .= '<br> Sum Total '.number_format($SumTotal,2);
	$content .= '<h4>Contact Information</h4>';
	$content .= '<div style="clear:both; margin-bottom: 20px;"></div>';
	$content .= '<strong>Name</strong> : <span>'.$name.'</span><br>';
	$content .= '<div style="clear:both; margin-bottom: 10px;"></div>';
	$content .= '<strong>Address</strong> : <span>'.$address.'</span><br>';
	$content .= '<div style="clear:both; margin-bottom: 10px;"></div>';
	$content .= '<strong>Email</strong> : <span>'.$email = isset($_SESSION['member_email']) && !empty($_SESSION['member_email']) ? $_SESSION['member_email'] :''.'</span><br>';
	$content .= '<div style="clear:both; margin-bottom: 10px;"></div>';
	$content .= '<strong>Date</strong> : <span>'.date('Y-m-d H:i:s').'</span>';
	
	return $content;
	
}

