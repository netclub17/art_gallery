<?php
session_start();

if(!isset($_SESSION["intLine"]))
{
	 $_SESSION["intLine"] = 0;
	 $_SESSION["strProductID"][0] = $_GET["pid"];
	 $_SESSION["strQty"][0] = 1;
}
else
{
	
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

redirect_to('/?show_order');

?>