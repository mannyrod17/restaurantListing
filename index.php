<?php
$servername = "localhost";
$username = "roem2666";
$password = "23172666";
$dbname = "roem2666";

//Create Connection
$conn = new mysqli($servername, $username, $password, $dbname);


//Check Connection
if ($conn->connect_error){
        die("Connection failed: ". $conn->connect_error);
}
$mode = $_REQUEST["mode"];
switch ($mode) {
    case "addRestaurant" :
        $restaurantName = $_REQUEST["name"];
        $address1 = intval($_REQUEST["address1"]);
        $address2 = intval($_REQUEST["address2"]);
        $openHoursStr = $_REQUEST["openHours"];
        $sql = "call insertNewRestaurant('".$restaurantName."',".$address1.",".$address2.",'".$openHoursStr."')";
        $conn->query($sql);
        break;
    case "addMenuItem" :
        $restaurantName = $_REQUEST["name"];
        $menuType = $_REQUEST['menuType'];
        $menuItem = $_REQUEST['menuItem'];
        $size = $_REQUEST['size'];
        $price = floatval($_REQUEST['price']);
        $sql= "call insertNewMenu('".$restaurantName."','".$menuType."','".$menuItem."','".$size."',".$price.")";
        $conn->query($sql);
        break;
    case "getMenu":
        $restaurantName = $_REQUEST["name"];
        $sql= "call getMenu('".$restaurantName."')";
        $result = $conn->query($sql);
        if ($result->num_rows >0){
            while ($row = $result->fetch_assoc()){
                echo $row["Type"].";".$row["Item"].";".$row["Size"].";".$row["Price"]."<br>";
            }
        }
        break;
    case "checkRestaurantAddress":
        $restaurantName = $_REQUEST["name"];
        $address1 = intval($_REQUEST["address1"]);
        $address2 = intval($_REQUEST["address2"]);
        $sql= "call searchRestaurantAddress('".$restaurantName."',".$address1.",".$address2.")";
        $result = $conn->query($sql);
        if($result->num_rows > 0) echo 1;
        break;
    case "checkAddress":
        $address1 = intval($_REQUEST["address1"]);
        $address2 = intval($_REQUEST["address2"]);
        $sql= "call searchAddress(".$address1.",".$address2.")";
        $result = $conn->query($sql);
        if($result->num_rows > 0) echo 1;
        break;
    case "checkRestaurant":
        $restaurantName = $_REQUEST["name"];
        $sql= "call searchRestaurant('".$restaurantName."')";
        $result = $conn->query($sql);
        if($result->num_rows > 0) echo 1;
        break;
    case "updateRestaurant":
        $restaurantName = $_REQUEST["name"];
        $address1 = intval($_REQUEST["address1"]);
        $address2 = intval($_REQUEST["address2"]);
        $openHoursStr = $_REQUEST["openHours"];
        $sql = "call updateRestaurant('".$restaurantName."',".$address1.",".$address2.",'".$openHoursStr."')";
        $conn->query($sql);
        break;
    case "deleteMenuItem":
        $restaurantName = $_REQUEST["name"];
        $menuItem = $_REQUEST['menuItem'];
        $menuType = $_REQUEST['menuType'];
        $sql= "DELETE FROM Menu WHERE (Restaurant = '".$restaurantName."' AND Item = '".$menuItem."' AND `Type` = '".$menuType."');";
        $conn->query($sql);
        break;
    case "deleteRestaurant":
        $restaurantName = $_REQUEST["name"];
        $address1 = intval($_REQUEST["address1"]);
        $address2 = intval($_REQUEST["address2"]);
        $sql= "call deleteRestaurant('".$restaurantName."',".$address1.",".$address2.")";
        $conn->query($sql);
        break;
    case "deleteMenu":
        $restaurantName = $_REQUEST["name"];
        $sql= "call deleteMenu('".$restaurantName."')";
        $conn->query($sql);
        break;

    default:
        $sql = "call getAllRestaurants";
        $result = $conn->query($sql);

        if ($result->num_rows >0){
            while ($row = $result->fetch_assoc()){
                echo $row["Restaurant"].";".$row["Address1"].";".$row["Address2"].";".$row["OpenHrs"]."<br>";
            }
        }
}

$conn->close();

?>