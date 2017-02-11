<?php
/**
 * Created by PhpStorm.
 * User: xinweiwang
 * Date: 4/13/16
 * Time: 2:08 AM
 */
session_start();
if (!isset($_SESSION["user"])) {

    echo "<script language='javascript'>";
    echo "alert(\"Please Login First\");";

    echo "location='index.php'";

    echo "</script>";

    exit();

}

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = serialize(array());

}
$cart = unserialize($_SESSION['cart']);
$keys = array_keys($cart);


try {
    $db = new PDO('mysql:host=localhost;dbname=test', "root", "root");
} catch (PDOException $e) {
    print "Error!: " . $e->getMessage() . "<br/>";
    $db = null;
    die();
}
?>

<head>
    <meta charset="UTF-8">
    <title>Cart</title>
    <link href="css/bootstrap.min.css" rel="stylesheet"/>

    <script src="js/jquery-1.12.0.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <style>

        a:hover {
            cursor: hand;
            text-decoration: none;
        }

        #show table {
            float: left;
            line-height: 30px;
            font-size: 20px;
        }

        #show img {
            height: 200px;
            width: 210px;
            margin-top: 15px;

        }
    </style>
    <script>
        $(document).ready(function () {
           price1();

        });
        function price(id){
            //alert($("#"+id).val());
            if($("#"+id).val()<=0){
                $.post("d.php", {"id": id, "num": $("#" + id).val()}, function (data) {

                });
                location.reload();
            }else {
                $.post("price.php", {"id": id, "num": $("#" + id).val()}, function (data) {
                    $("#total").text("Total Price: $" + data);

                });
            }
        }
        function price1(){
            //alert(this.innerText);
            $.post("price.php",{"id":-1,"num":-1},function(data){
                $("#total").text("Total Price: $"+data);

            });
        }
    </script>
</head>
<body>
<!-- header-->
<div class="container-fluid">
    <div class="row" style="height:60px;">
        <div class="col-xs-3" style="margin-top: 5px;">
            <img src="img/logo.png" style="height:80%;width: 100%;"/>
        </div>
        <div class="col-xs-1">

        </div>
        <div class="col-xs-6">
            <form class="form-inline" role="form" style="margin-top: 14px" action="searchName.php" method="get">

                <input type="text" class="form-control" style="width: 80%" name="name" placeholder="Search By Item Name">

                <button type="submit" class="btn btn-default" style="color: orange;">Search</button>
            </form>
        </div>
    </div>
</div>
<!-- navbar -->
<nav class="navbar navbar-inverse" style="margin: 0px;">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>

        </div>
        <div class="collapse navbar-collapse" id="myNavbar">
            <ul class="nav navbar-nav">
                <li><a href="index.php">Home</a></li>
                <li><a  href="position.php?position=Wheel">Wheel</a></li>
                <li><a  href="position.php?position=Light">Light</a></li>
                <li><a  href="position.php?position=Inner Parts">Inner Parts</a></li>
                <li><a  href="position.php?position=Exterior Parts">Exterior Parts</a></li>
            </ul>
            <ul class="nav navbar-nav navbar-right">

                <li><a href="account.php"><span class="glyphicon glyphicon-user"></span> Your Account</a></li>
                <li><a href="login.php?type=2"><span class="glyphicon glyphicon-log-out"></span> Logout</a></li>

            </ul>
        </div>
    </div>
</nav>

<div class="container-fluid">
    <div class="row">
        <div class="col-sm-offset-1 col-sm-10" style="margin-top: 10px;">
            <div class="panel panel-primary">
                <div class="panel-heading">My Cart</div>
                <div class="panel-body">
                    <?php
                    if (count($keys) != 0) {

                        ?>
                        <form class="form-horizontal" role="form" action="checkout.php">
                            <?php
                            foreach ($keys as $key) {
                                $rows = $db->query("SELECT * from parts where id=$key");
                                if ($rows->rowCount() > 0) {
                                    $num = $cart[$key];
                                    $row = $rows->fetch();
                                    $id = $row['id'];
                                    $name = $row['name'];
                                    $position = $row['position'];
                                    $type = $row['type'];
                                    $price = $row['price'];
                                }
                                ?>
                                <div class="form-group">
                                    <label class="control-label col-sm-2">Name: <?= $name ?></label>
                                    <label class="control-label col-sm-2">Position: <?= $position ?></label>
                                    <label class="control-label col-sm-3">Manufacturer: <?= $type ?></label>
                                    <label class="control-label col-sm-2">Price: <?= $price ?></label>
                                    <label class="control-label col-sm-1">Number: </label>
                                    <div class="col-sm-2">
                                        <input type="text" class="form-control" value="<?= $num ?>" id="<?=$id?>" onchange="price(<?=$id?>)">
                                    </div>
                                </div>

                                <?php
                            }
                            $db = null;
                            ?>
                            <div class="form-group">
                                <label class="control-label col-sm-3" id="total"></label>
                            </div>
                            <div class="form-group" style="margin: 0px;">
                                <div class="col-sm-offset-8 col-sm-3">
                                    <button type="submit" class="btn btn-default btn-block">Check Out</button>
                                </div>
                            </div>
                        </form>
                        <?php
                    }else{
                        ?>
                        <div>
                            No item in cart.
                        </div>
                    <?php
                    }
                    ?>
                    <div class="col-sm-offset-8 col-sm-3">
                        <a href="index.php"><button class="btn btn-default btn-block">Keep Shopping</button></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



