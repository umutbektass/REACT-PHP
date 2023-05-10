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
        $path=explode('/',$_SERVER['REQUEST_URI']);
        if(isset($path[3]) && is_numeric($path[3]))
        {
                $json_array=array();
                $userid=$path[3];
                $getuserrow = mysqli_query($db_conn,"SELECT * FROM product  where id='$userid' ");
                while ($userrow = mysqli_fetch_array($getuserrow)) {
                    $json_array['rowUserdata']=array('id'=>$userrow['id'],'title'=>$userrow['title'],'description'=>$userrow['description']);
                }
                echo json_encode($json_array['rowUserdata']);
                return;

        }

            else{
       $alluser=mysqli_query($db_conn,"SELECT * FROM product");
       if(mysqli_num_rows($alluser)>0){
        while ($row=mysqli_fetch_array($alluser)) {
            $json_array["userdata"][]=array("id"=>$row["id"],"title"=>$row["title"],"description"=>$row["description"]);
        }
        echo json_encode($json_array["userdata"]);
        return;
       }
       else{
        echo json_encode(["result"=>"Please check the Data"]);
        return;
       }
    }
        break;


        case "POST":
            $userpostdata= json_decode(file_get_contents("php://input"));
            // echo "succes data";
            // print_r($userpostdata); die;
            $title=$userpostdata->title;
            $description=$userpostdata->description;
            $result = mysqli_query($db_conn,"INSERT INTO product (title,description,file) VALUES('$title','$description','1') ");
            if($result){
                echo json_encode(["success"=>"User Added success"]);
                return;
            }
            else{
                echo json_encode(["success"=>"Please Check The User Data"]);
                return;
            }
            break;

            case "PUT":
                $userUpdate=json_decode(file_get_contents("php://input"));
                $id = $userUpdate->id;
                $title = $userUpdate->title;
                $description = $userUpdate->description;
                $updateData = mysqli_query($db_conn, "UPDATE product SET title='$title', description='$description'
                WHERE id='$id' ");
                 if($updateData){
                    echo json_encode(["success"=>"User Update success"]);
                    return;
                }
                else{
                    echo json_encode(["success"=>"Please Check The User Data"]);
                    return;
                }

                print_r($userUpdate); die;
                break;


                case "DELETE":
                    $path = explode('/',$_SERVER["REQUEST_URI"]);
                    $result  = mysqli_query($db_conn,"DELETE FROM product  WHERE id = '$path[3]' ");
                    if($result){
                        echo json_encode(["success"=>"User Delete success"]);
                        return;
                    }
                    else{
                        echo json_encode(["success"=>"Please Check The User Data"]);
                        return;
                    }
    default:
        # code...
        break;
}




?>