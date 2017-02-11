<?php
if($_POST["name"]==""||$_POST["type"]==""||$_POST["position"]==""||$_POST["price"]==""||$_POST["updateType"]==""){
    $msg="update fail！Parameter is null!";
}else {
    try {
        $db = new PDO('mysql:host=localhost;dbname=test', "root", "root");

        //$dbh = null;
    } catch (PDOException $e) {

        $msg= "Update fail! Error!: " . $e->getMessage();
        $db = null;
        die();
    }
    if($db!=null) {

        $name = $db->quote($_POST["name"]);
        $position = $db->quote($_POST["position"]);
        $type = $db->quote($_POST["type"]);
        $price = $_POST["price"];
        $f=true;
        if($_POST["updateType"]=="1") {
            try {

                $db->beginTransaction();
                $db->exec("insert into parts values (null, $name, $position,$type,$price)");
                $rows = $db->query("select last_insert_id()");
                if ($rows->rowCount() > 0) {
                    $row = $rows->fetch();
                    $id = $row[0];
                }
                $db->commit();
                $db = null;
            } catch (Exception $e) {
                $db->rollBack();
                $db = null;
                $msg = "Update fail! Error: " . $e->getMessage();
                $f = false;
            }
        }else if($_POST["updateType"]=="2"){
            try {
                $id=$_POST['id'];
                $db->beginTransaction();
                $db->exec("update parts set name=$name, position=$position,type=$type,price=$price where id=$id");
                $db->commit();
                $db = null;
            } catch (Exception $e) {
                $db->rollBack();
                $db = null;
                $msg = "Update fail! Error: " . $e->getMessage();
                $f = false;
            }
        }
    }
    if($f) {

        $path = "partsImg/";        //上传路径

//echo $_FILES["filename"]["type"];


        if (!file_exists($path)) {
            //检查是否有该文件夹，如果没有就创建，并给予最高权限
            mkdir("$path", 0700);
        }//END IF
//允许上传的文件格式

//检查上传文件是否在允许上传的类型

        if ($_FILES["filename"]["name"]) {
            $file1 = $_FILES["filename"]["name"];
            $file2 = $path . $id . ".jpg";
            $flag = 1;
        }//END IF
        if ($flag) $result = move_uploaded_file($_FILES["filename"]["tmp_name"], $file2);
//特别注意这里传递给move_uploaded_file的第一个参数为上传到服务器上的临时文件
        //END IF
        $msg="Update Success!";
    }
}
echo "<script language='javascript'>";
echo "alert(\"".$msg."\");";
if(isset($_POST['updateType'])&&$_POST['updateType']==2){
    $updateType=$_POST["updateType"];
    $name = $_POST["name"];
    $position = $_POST["position"];
    $type = $_POST["type"];
    $price = $_POST["price"];
    echo "location='addPart.php?updateType=2&id=".$id."&name=".$name."&position=".$position."&type=".$type."&price=".$price."'";
}else{
    echo "location='addPart.php?updateType=1'";
}
echo "</script>";