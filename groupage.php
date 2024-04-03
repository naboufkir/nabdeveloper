<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
error_reporting(E_ALL & ~E_NOTICE);

//phpinfo();die;

// feuture / product https://sportsmaster.gr/api/products/50964/features
// KQ0xa6176N0214Z6c8yC820xW3h46hpG
//eGNhcnRlc2hvcEBnbWFpbC5jb206S1EweGE2MTc2TjAyMTRaNmM4eUM4MjB4VzNoNDZocEc=



function get_feature_into_array($lecodeproduct)
{
	
 

$mysql_host1 = 'localhost'; 
$mysql_username1 = 'cscartnicepack'; 
$mysql_password1 = 'Xcart654321@@'; 
$mysql_database1 = 'cscartnicepack'; 	

	
	
	
	@set_time_limit(0);
	@ini_set('memory_limit', '2048M');


 $mysqli1 = new mysqli($mysql_host1, $mysql_username1, $mysql_password1, $mysql_database1);





if ($mysqli1->connect_error) {
    die('Error : ('. $mysqli1->connect_errno .') '. $mysqli1->connect_error);
}

$sql = "SELECT cscart_product_features_values.product_id, 
cscart_product_features_values.variant_id,
cscart_product_features_values.feature_id AS feature_id,
cscart_product_features.purpose AS purpose
FROM cscart_product_features INNER JOIN cscart_product_features_values 
ON cscart_product_features_values.feature_id = cscart_product_features.feature_id 
WHERE cscart_product_features_values.product_id =".$lecodeproduct." 
AND (cscart_product_features.purpose = 'group_catalog_item' OR  cscart_product_features.purpose ='group_variation_catalog_item')";

$result1 = mysqli_query($mysqli1, $sql);
$xx=0;	$jsonData= "";
if (mysqli_num_rows($result1) > 0) {
  // output data of each row
  while($row1 = mysqli_fetch_assoc($result1))
  {
    //echo  "<br>". "<br>"."Features  :   " . $row1["feature_id"]. "<br>". "<br>";
	 $feturation['a']=$row1["feature_id"];
	 $feturation['a']=$row1["feature_id"];
	  
	  $app = new App();
      $app->feature_id = $row1["feature_id"];
      $app->purpose = $row1["purpose"];
	  $jsonData .= json_encode($app);
      $jsonData .=","; 
	  
	  $xx=$xx+1;
  }
}
	
//Array ( [0] => 1 [1] => 2 [2] => 27 [3] => 43 [4] => 234 [5] => 235 [6] => 236 [7] => 237 [8] => 238 [9] => 239 [10] => 240 [11] => 241 [12] => 242 [13] => 243 [14] => 244 [15] => 245 ) 	
	
//print_r($feturation);
	
//	echo mysqli_num_rows($result1);

return $jsonData;

}



class App {
  
}

function random_strings($length_of_string)
{
 
    // String of all alphanumeric character
    $str_result = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
 
    // Shuffle the $str_result and returns substring
    // of specified length
    return substr(str_shuffle($str_result),
                       0, $length_of_string);
}






$mysql_host = 'localhost'; 
$mysql_username = 'cscartnicepack'; 
$mysql_password = 'Xcart654321@@'; 
$mysql_database = 'cscartnicepack'; 




	@set_time_limit(0);
	@ini_set('memory_limit', '2048M');


 $mysqli = new mysqli($mysql_host, $mysql_username, $mysql_password, $mysql_database);

if ($mysqli->connect_error) {
    die('Error : ('. $mysqli->connect_errno .') '. $mysqli->connect_error);
}

mysqli_set_charset($mysqli,"utf8");

$sql = "SELECT Group_Concat(DISTINCT cscart_products.product_id) AS features, cscart_products.product_sku_nicepack AS sku, cscart_products.product_code AS product_code FROM cscart_products 
WHERE (cscart_products.product_sku_nicepack <> '' AND cscart_products.product_sku_nicepack <> '0')
GROUP BY cscart_products.product_sku_nicepack";

$result = mysqli_query($mysqli, $sql);

if (mysqli_num_rows($result) > 0) {
  // output data of each row
  while($row = mysqli_fetch_assoc($result)) {
//    echo  "<br>". "<br>"."Features  :   " . $row["features"]. " - Code groupe : " . $row["sku"]. "    le code :  " . $row["product_code"]. "<br>". "<br>";
$le_code_feature = strtok($row["features"], ',');

//echo $le_code_feature;
$lesfeautures_product = get_feature_into_array($le_code_feature);

$lesfeautures_product = rtrim($lesfeautures_product, ',');	  
	  
print_r($lesfeautures_product);
echo "stopped 01";  
	print_r($arr);  

	 $variant_number='OPEN';

$legroup_var= random_strings(9);
$pv_group = sprintf('PV-%s', $legroup_var);	 

//{ "product_ids":[414,2351,146,746], "code": "PV-8A4HGN052", "features":[{"feature_id":"27","purpose":"group_variation_catalog_item"}] }	  

 	  
	 $xml_request= '{
"product_ids":['.$row["features"].'],
"code": "'.$pv_group.'",
"features":['.$lesfeautures_product.']
}';
echo "<br>";print_r($xml_request);echo "<br>";
	 $payload = $xml_request;
$ch = curl_init('https://realtorcrm.gr/api/product_variations_groups');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLINFO_HEADER_OUT, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    'Content-Type: application/json',
   	'Authorization: Basic eGNhcnRlc2hvcEBnbWFpbC5jb206MjUzOUp1OTc2cjIyNzM1OTU0M241d240YzQxcWhmcjM=')
);
$resulta = curl_exec($ch);
$resulta = json_decode($resulta);
print_r($resulta);//die;
curl_close($ch);
	  
	 // die;
	

 	  
	  
	
	  
	  
  }
} else {
  echo "0 results";
}

mysqli_close($mysqli);

echo "stopped ";die;


	


function feature_creation($feature_id_exit_original,$the_feature,$the_feature_value,$le_purpose)
{
//echo $feature_id_exit_original;die;
global $mysqli;
if ($the_feature !="Brand")
{

$mysqli->query("INSERT INTO `cscart_product_features` (`feature_id`, `feature_code`, `company_id`, `purpose`, `feature_style`, `filter_style`, `feature_type`, `categories_path`, `parent_id`, `display_on_product`, `display_on_catalog`, `display_on_header`, `status`, `position`, `comparison`) VALUES
(default, '', 1, '$le_purpose', 'text', 'checkbox', 'S', '', 0, 'Y', 'Y', 'N', 'A', 290, 'N')");
}
else
{

$mysqli->query("INSERT INTO `cscart_product_features` (`feature_id`, `feature_code`, `company_id`, `purpose`, `feature_style`, `filter_style`, `feature_type`, `categories_path`, `parent_id`, `display_on_product`, `display_on_catalog`, `display_on_header`, `status`, `position`, `comparison`) VALUES
(default, '', 1, 'organize_catalog', 'brand', 'checkbox', 'E', '', 0, 'Y', 'Y', 'N', 'A', 10, 'N')");

}

 $latest_feature_id =  mysqli_insert_id($mysqli); 
echo 	" ".$latest_feature_id."  ";
 $mysqli->query("INSERT INTO `cscart_product_features_descriptions` (`feature_id`,`internal_name`, `description`, `full_description`, `prefix`, `suffix`, `lang_code`) VALUES
($latest_feature_id, '$the_feature','$the_feature', '', '', '', 'el')");


 $mysqli->query("INSERT INTO `cscart_product_feature_variants` (`variant_id`, `feature_id`, `url`, `color`, `position`) VALUES
(default, $latest_feature_id, '', NULL, 0)");

$latest_feature_id_variante =  mysqli_insert_id($mysqli); 


$mysqli->query("INSERT INTO `cscart_product_feature_variant_descriptions` (`variant_id`, `variant`, `description`, `page_title`, `meta_keywords`, `meta_description`, `lang_code`) VALUES
($latest_feature_id_variante, '$the_feature_value', NULL, '', '', '', 'el')");


$mysqli->query("INSERT INTO `cscart_ult_objects_sharing` (`share_company_id`, `share_object_id`, `share_object_type`) VALUES
(1, $latest_feature_id, 'product_features')");


//echo " ddddddddddddddddddddd  done ";die;
	
}


function feature_update($feature_id_exit_original,$the_feature,$the_feature_value)
{
	global $mysqli;
echo $feature_id_exit_original;
$feature_id_exit = $feature_id_exit_original;
	$langkikh = 'el';
	$feature_id_exit_value = $mysqli->query("SELECT variant_id FROM `cscart_product_feature_variant_descriptions` WHERE `variant`='".$the_feature_value."'"." AND lang_code ='".$langkikh."'")->fetch_object()->variant_id;

	//echo "   ".$feature_id_exit_original."   ".$feature_id_exit_value;die;
	

	
	
echo	"SELECT `variant_id` FROM `cscart_product_features_values` WHERE `product_id`='".$the_product_id."'"." AND feature_id ='".$feature_id_exit."'"."<br>";
	
//echo "feut id ================> ".$feature_id_exit_original."  ".$the_product_id."   ".$feature_id_exit_value."<br>";		
	
//	$feature_id_exit_value = $mysqli->query("SELECT `variant_id` FROM `cscart_product_feature_variant_descriptions` WHERE //`variant`='".$the_feature_value."'")->fetch_object()->variant_id;
	 
	if(!$feature_id_exit_value)
	{	
	  $mysqli->query("INSERT INTO `cscart_product_feature_variants` (`variant_id`, `feature_id`, `url`, `color`, `position`) VALUES
           (default, $feature_id_exit, '', NULL, 0)");

             $feature_id_exit_var =  mysqli_insert_id($mysqli); 

$mysqli->query("INSERT INTO `cscart_product_feature_variant_descriptions` (`variant_id`, `variant`, `description`, `page_title`, `meta_keywords`, `meta_description`, `lang_code`) VALUES
($feature_id_exit_var, '$the_feature_value', NULL, '', '', '', 'el')");

	}
	
	else
	
	{ 
	
	 
$mysqli->query("UPDATE  `cscart_product_feature_variant_descriptions` SET  `variant`='$the_feature_value' WHERE `variant_id`=".$feature_id_exit_value);	 

 		
	}


}



function eurolamp_import_updating_or_creating_new_features($the_feature,$the_feature_value,$le_purpose)
{
global $mysqli;
echo $the_product_id." ".$the_feature." ".$the_feature_value."<br>";
	
$feature_id_exit_original = $mysqli->query("SELECT feature_id FROM  cscart_product_features_descriptions WHERE `description` = '".$the_feature."'")->fetch_object()->feature_id;
 
//echo $feature_id_exit_original."ghghfg<br>";
	
 if(!$feature_id_exit_original)
      {
	 
feature_creation($feature_id_exit_original,$the_feature,$the_feature_value,$le_purpose);


	  }
		
else
		
	 {
	//echo $feature_id_exit_original."ghghfg<br>";
feature_update($feature_id_exit_original,$the_feature,$the_feature_value);	
			
	 }




}




function save_from_url($inPath,$outPath)
{ //Download images from remote server
    $in=    fopen($inPath, "rb");
    $out=   fopen($outPath, "wb");
    while ($chunk = fread($in,8192))
    {
        fwrite($out, $chunk, 8192);
    }
    fclose($in);
    fclose($out);
}






$mysql_host = 'localhost'; 
$mysql_username = 'panscandNew'; 
$mysql_password = 'vEon8@49'; 
$mysql_database = 'panscandNew'; 



	@set_time_limit(0);
	@ini_set('memory_limit', '2048M');


 $mysqli = new mysqli($mysql_host, $mysql_username, $mysql_password, $mysql_database);





if ($mysqli->connect_error) {
    die('Error : ('. $mysqli->connect_errno .') '. $mysqli->connect_error);
}

mysqli_set_charset($mysqli,"utf8");


$url = "https://shop.athlopaidia.com/xml/Products.xml";

libxml_use_internal_errors(TRUE);
 
$objXmlDocument = simplexml_load_file($url);
if ($objXmlDocument === FALSE) {
    echo "There were errors parsing the XML file.\n";
    foreach(libxml_get_errors() as $error) {
        echo $error->message;
    }
    exit;
}






//print_r($objXmlDocument);die;

$category_id_exit_root = $mysqli->query("SELECT category_id FROM  cscart_category_descriptions WHERE category = 'athlopaidia///'")->fetch_object()->category_id;


if (!$category_id_exit_root)
{

$mysqli->query("INSERT INTO `cscart_categories` (`category_id`, `parent_id`, `id_path`, `level`, `company_id`, `usergroup_ids`, `status`, `product_count`, `position`, `timestamp`, `is_op`, `localization`, `age_verification`, `age_limit`, `parent_age_verification`, `parent_age_limit`, `selected_views`, `default_view`, `product_details_view`, `product_columns`, `is_trash`) VALUES
(default, 0, '', 1, 1, '0', 'A', 0, 0, 1590500103, 'N', '', 'N', 0, 'N', 0, NULL, '', '', 0, 'N')");

	
//$mysqli->query("INSERT INTO `cscart_categories` (`category_id`, `parent_id`, `id_path`, `level`, `company_id`, `usergroup_ids`, `status`, `product_count`, `position`, `timestamp`, `is_op`, `localization`, `age_verification`, `age_limit`, `parent_age_verification`, `parent_age_limit`, `selected_views`, `default_view`, `product_details_view`, `product_columns`, `is_trash`, `abt__yt_banners_use`, `abt__yt_banner_max_position`, `ab__lc_catalog_image_control`, `ab__lc_landing`, `ab__lc_subsubcategories`, `ab__lc_menu_id`, `ab__lc_how_to_use_menu`, `ab__lc_inherit_control`) VALUES
//(default, 0, '', 1, 1, '0', 'D', 0, 0, 1616965200, 'N', '', 'N', 0, 'N', 0, '', '', 'default', 0, 'N', 'N', 60, 'none', 'N', 0, 0, 'N', 'N')");

 $latest_id_cat =  mysqli_insert_id($mysqli);    
    //echo "Insert successful. Latest ID is: " . $latest_id_cat;die;
    $newcat_id= $latest_id_cat;


$mysqli->query("UPDATE `cscart_categories` SET `id_path`='".$newcat_id."' WHERE `category_id`=".$newcat_id);

$mysqli->query("INSERT INTO `cscart_category_descriptions` (`category_id`, `lang_code`, `category`, `description`, `meta_keywords`, `meta_description`, `page_title`, `age_warning_message`) VALUES
($newcat_id, 'el', 'athlopaidia///', NULL, '', '', '', NULL)");

	
	
//echo "category insered  Eurolamp  ";die;

$category_id_exit_root = $newcat_id;
}


$objJsonDocument = json_encode($arr,JSON_FORCE_OBJECT);
$arrOutput = json_decode($objJsonDocument, TRUE);
$i=0;

//echo $objXmlDocument;die;

foreach($objXmlDocument->children() as $empl) {         
 echo "Select `product_code` From cscart_products where product_code='".$empl->sku."'";//die;
 //echo "Select `product_id`,`product_code`,`status`,`amount` From cscart_products where product_code='".$empl->SKU."'"."<br/>" ; 
  $results = $mysqli->query("Select `product_code` From cscart_products where product_code='".$empl->sku."'");
  
 
if ($results) {
	//echo mysqli_num_rows($results)."<br/>" ;
  if (mysqli_num_rows($results) > 0) {
    //echo "code  in database  : ".$empl->SKU."<br/>" ;
  } else {
    echo "code not in database  :  --------------------------------- >".$empl->sku."       product Id = "."<br/>" ;
//  
//          echo "code not in database  :  --------------------------------- >".$empl->NAME."<br/>" ;
//	 	echo "code not in database  :  --------------------------------- >".$empl->MANUFACTURER."<br/>" ;
//		 echo "code not in database  :  --------------------------------- >".$empl->MAIN_IMAGE."<br/>" ;
//		 echo "code not in database ID :  --------------------------------- >".$empl->CATEGORY->id."<br/>" ;
//		  echo "code not in database  :  --------------------------------- >".$empl->CATEGORY_TITLE."<br/>" ;
//		  echo "code not in database  :  --------------------------------- >".$empl->PRICE_INTERNET_WITH_VAT."<br/>" ;
//		   echo "code not in database  :  --------------------------------- >".$empl->META_DESCRIPTION."<br/>" ;
//		   echo "code not in database  :  --------------------------------- >" .$empl->META_KEYWORD."<br/>" ;
//			 echo "code not in database  :  --------------------------------- >".$empl->DESCRIPTION."<br/>" ;
//			 echo "code not in database  :  --------------------------------- >" .$empl->WEIGHT."<br/>" ;
//			  echo "code not in database  :  --------------------------------- >" .$empl->WEIGHT."<br/>" ;
//			   echo "code not in database  :  --------------------------------- >" .$empl->AVAILABILITY."<br/>" ;
  $i=$i+1;


  
	  
$empl->name = str_replace("'","",$empl->name);
$empl->name_en = str_replace("'","",$empl->name_en);
$empl->description = str_replace("'","",$empl->description);
$empl->description_en = str_replace("'","",$empl->description);
$la_category_item = str_replace(",",">",$empl->categories);
	  

$category_id_exit = $mysqli->query("SELECT category_id FROM  cscart_category_descriptions WHERE category = '".$la_category_item."'")->fetch_object()->category_id;



if(!$category_id_exit)
{
$mysqli->query("INSERT INTO `cscart_categories` (`category_id`, `parent_id`, `id_path`, `level`, `company_id`, `usergroup_ids`, `status`, `product_count`, `position`, `timestamp`, `is_op`, `localization`, `age_verification`, `age_limit`, `parent_age_verification`, `parent_age_limit`, `selected_views`, `default_view`, `product_details_view`, `product_columns`, `is_trash`) VALUES
(default, $category_id_exit_root, '', 1, 1, '0', 'D', 0, 0, 1590500103, 'N', '', 'N', 0, 'N', 0, NULL, '', '', 0, 'N')");

 $latest_id_cat =  mysqli_insert_id($mysqli);    
  //  echo "Insert successful. Latest ID is: " . $latest_id_cat;
    $newcat_id= $category_id_exit_root."/".$latest_id_cat;


$mysqli->query("UPDATE `cscart_categories` SET `id_path`='".$newcat_id."' WHERE `category_id`=".$latest_id_cat);

$mysqli->query("INSERT INTO `cscart_category_descriptions` (`category_id`, `lang_code`, `category`, `description`, `meta_keywords`, `meta_description`, `page_title`, `age_warning_message`) VALUES
($latest_id_cat, 'el', '$la_category_item', NULL, '', '', '', NULL)");

$category_id_exit = $latest_id_cat;

}

	  
	  
	  
$as_same_product = 'group_variation_catalog_item'; 	
$as_other_product = 'group_catalog_item';	
$normal_product  = 'find_products';
$brand_product = 'organize_catalog';  
	  


if ($empl->size)
{
 $the_feature_label = "size";
 $the_feature_value = $empl->size;
 $le_purpose = $as_same_product;
 eurolamp_import_updating_or_creating_new_features($the_feature_label,$the_feature_value,$le_purpose);

$feature_id_size = $mysqli->query("SELECT feature_id FROM  cscart_product_features_descriptions WHERE `description` = '".$the_feature_label."'")->fetch_object()->feature_id;

$variate_id_size = $mysqli->query("SELECT variant_id FROM  cscart_product_feature_variant_descriptions WHERE `variant` = '".$the_feature_value."'")->fetch_object()->variant_id;

	

}

	  if ($empl->target)
{
 $the_feature_label = "target";
 $the_feature_value = $empl->target;
 $le_purpose = $as_same_product;
 eurolamp_import_updating_or_creating_new_features($the_feature_label,$the_feature_value,$le_purpose);

$feature_id_target = $mysqli->query("SELECT feature_id FROM  cscart_product_features_descriptions WHERE `description` = '".$the_feature_label."'")->fetch_object()->feature_id;

$variate_id_target = $mysqli->query("SELECT variant_id FROM  cscart_product_feature_variant_descriptions WHERE `variant` = '".$the_feature_value."'")->fetch_object()->variant_id;

	  
	  
	  }
		  if ($empl->type)
{
 $the_feature_label = "type";
 $the_feature_value = $empl->type;
 $le_purpose = $as_same_product;
 eurolamp_import_updating_or_creating_new_features($the_feature_label,$the_feature_value,$le_purpose);


$feature_id_type = $mysqli->query("SELECT feature_id FROM  cscart_product_features_descriptions WHERE `description` = '".$the_feature_label."'")->fetch_object()->feature_id;

$variate_id_type = $mysqli->query("SELECT variant_id FROM  cscart_product_feature_variant_descriptions WHERE `variant` = '".$the_feature_value."'")->fetch_object()->variant_id;

	  
		  
		  
		  }

			  if ($empl->diameter)
{
 $the_feature_label = "diameter";
 $the_feature_value = $empl->diameter;
 $le_purpose = $as_same_product;
 eurolamp_import_updating_or_creating_new_features($the_feature_label,$the_feature_value,$le_purpose);


$feature_id_diameter = $mysqli->query("SELECT feature_id FROM  cscart_product_features_descriptions WHERE `description` = '".$the_feature_label."'")->fetch_object()->feature_id;

$variate_id_diameter = $mysqli->query("SELECT variant_id FROM  cscart_product_feature_variant_descriptions WHERE `variant` = '".$the_feature_value."'")->fetch_object()->variant_id;

			  
			  
			  }	
	  
			  if ($empl->color)
{
	  
 $the_feature_label = "color";
 $the_feature_value = $empl->color;
 $le_purpose = $as_other_product;	  
 eurolamp_import_updating_or_creating_new_features($the_feature_label,$the_feature_value,$le_purpose);

$feature_id_color = $mysqli->query("SELECT feature_id FROM  cscart_product_features_descriptions WHERE `description` = '".$the_feature_label."'")->fetch_object()->feature_id;

$variate_id_color = $mysqli->query("SELECT variant_id FROM  cscart_product_feature_variant_descriptions WHERE `variant` = '".$the_feature_value."'")->fetch_object()->variant_id;

			  }
	  

	  if ($empl->manufacturer)
{
 $the_feature_label = "Brand";
 $the_feature_value = $empl->manufacturer;
 $le_purpose = $brand_product;	 
 eurolamp_import_updating_or_creating_new_features($the_feature_label,$the_feature_value,$le_purpose);


$feature_id_manufacturer = $mysqli->query("SELECT feature_id FROM  cscart_product_features_descriptions WHERE `description` = '".$the_feature_label."'")->fetch_object()->feature_id;

$variate_id_manufacturer = $mysqli->query("SELECT variant_id FROM  cscart_product_feature_variant_descriptions WHERE `variant` = '".$the_feature_value."'")->fetch_object()->variant_id;

			  

}	  

$quantite_importe = $empl->quantity;
$le_poids = 0.5;
if ($empl->availability  == "In Stock") {$quantite_importe = 20;}
if ($empl->availability  == "Low Stock") {$quantite_importe = 2;}

//die;
$le_code_product= $empl->sku;
$le_product_type = $empl->product_type;
	  echo $le_product_type."         ";
	  if ($le_product_type == "Child")
	  {$le_product_type ="V"; $le_code_parent= strtok($le_code_product, '/');
	 
$le_parent_id = $mysqli->query("SELECT `product_id` FROM `cscart_products` WHERE `product_code` ='".$le_code_parent."'")->fetch_object()->product_id;

	  
	  } else {$le_product_type ="P";$le_code_parent= "";$le_parent_id=0;}
	//echo $le_product_type."         ".$le_code_parent."         ";

$le_prix = $empl->price;

	  
$empl->name = str_replace("'","",$empl->name);
$empl->name_en = str_replace("'","",$empl->name_en);
$empl->description = str_replace("'","",$empl->description);
$empl->description_en = str_replace("'","",$empl->description);
$la_category_item = str_replace(",",">",$empl->categories);	  

$main_category_id = $mysqli->query("SELECT category_id FROM  cscart_category_descriptions WHERE category = '".$la_category_item."'")->fetch_object()->category_id;
	  
 
	  
$xml_request= '{
"product": "'.$empl->name.'",
"product_code": "'.$empl->sku.'",
"category_ids": "'.$main_category_id.'",
"main_category": "'.$main_category_id.'",
"short_description": "'.$empl->name.'",
"full_description": "'.$empl->description.'",
"price": "'.$le_prix.'",
"amount": "'.$quantite_importe.'",
"parent_product_id":0,
"status": "A",
"product_features":{
	"'.$feature_id_manufacturer.'":"'.$variate_id_manufacturer.'",
	"'.$feature_id_color.'":"'.$variate_id_color.'",
     "'.$feature_id_diameter.'":"'.$variate_id_diameter.'",
	"'.$feature_id_type.'":"'.$variate_id_type.'",
     "'.$feature_id_target.'":"'.$variate_id_target.'",
     "'.$feature_id_size.'":"'.$variate_id_size.'"
	 },
"main_pair": {
        "detailed": {
            "image_path": "'.$empl->image.'"
        }
    },
    "image_pairs": [
        {
            "detailed": {
                "image_path": "'.$empl->image1.'"
            }
        },
        {
            "detailed": {
                "image_path": "'.$empl->image2.'"
            }
        },
        {
            "detailed": {
                "image_path": "'.$empl->image3.'"
            }
        },

{
            "detailed": {
                "image_path": "'.$empl->image4.'"
            }
        }
    ]

}';


	  
	  
	  
	  
 $payload = $xml_request;
print_r($payload);echo "<br>";//die;
// Initialise new cURL session
$ch = curl_init('https://sportsmaster.gr/api/products');

// Return result of POST request
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

// Get information about last transfer
curl_setopt($ch, CURLINFO_HEADER_OUT, true);

// Use POST request
curl_setopt($ch, CURLOPT_POST, true);

// Set payload for POST request
curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
 
// Set HTTP Header for POST request 
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    'Content-Type: application/json',
   	'Authorization: Basic eGNhcnRlc2hvcEBnbWFpbC5jb206WjhPODQ4OG00VmpaTDJ3OXQwMzhTcVUwZ1U4WWV1YzI=')
);
 
// Execute a cURL session
$result = curl_exec($ch);
 //echo " here ";

// Close cURL session

$result = json_decode($result);
print_r($result);//die;
	  echo "<br>"; //echo "here ";die;
curl_close($ch);		  
	  
	  
	  
	  
	  
	  
	  
	  
	  
	  
	  
	  
	  

//die;
  }
} else {
  echo 'Error: ';
}

//if ($i>100)

//$category_id_exit_drop = $mysqli->query("SELECT category_id FROM  cscart_category_descriptions WHERE category = '///'")->fetch_object()->category_id;
//$mysqli->query("DELETE FROM  `cscart_categories`  WHERE `category_id`=".$category_id_exit_drop);
//$mysqli->query("DELETE FROM  cscart_category_descriptions  WHERE `category_id`=".$category_id_exit_drop);
//$mysqli->query("DELETE FROM  `cscart_products_categories`  WHERE `category_id`=".$category_id_exit_drop);


 //{echo  "stopped  ";die;} 
 //$i=$i+1;
} 
echo "job Ended  ".$i."  Products Imported ";
exit;


 