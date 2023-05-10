<?php
error_reporting(E_ALL);
ini_set('display_errors',1);
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");
header("Access-Control-Allow-Methods: *");

$db_conn=mysqli_connect("localhost","root","","products");
if($db_conn===false){
    die("ERROR: COULD NOT CONNECT ".mysqli_connect_error());
}
$method=$_SERVER['REQUEST_METHOD'];


switch ($method) {
    case 'GET':
       echo 'Get Api'; die;
        break;


        case "POST":
            if(isset($_FILES['pfile'])){
                    $ptitle=$_POST['ptitle'];
                    $pdescription=$_POST['pdescription'];
                    $pfile=time().$_FILES['pfile']['name'];
                    $pfile_temp=$_FILES['pfile']['tmp_name'];
                    $destination = $_SERVER['DOCUMENT_ROOT'].'/php-dersleri/uploads'."/".$pfile;
                    $result = mysqli_query($db_conn,"INSERT INTO product (title,description,file) VALUES ('$ptitle','$pdescription','$pfile')");
                    if($result)
                    {
                        move_uploaded_file($pfile_temp,$destination);
                        echo json_encode(["success"=>"product ıntert"]);
                        return;

                    }else{
                        echo json_encode(["success"=>"product not ınterted"]);
                        return;

                    }
                   
            }else{
                echo json_encode(["success"=>"data nor in correct"]);
                        return;
            }
            
            break;


                case "DELETE":
                  break;
    default:
        # code...
        break;
}




?>