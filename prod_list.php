<?php
include "connectdb.php";
// if(!isset($_SESSION["username"])){
//     header("Location:login.php");
//     exit;
// }

$str_query="SELECT * FROM product LIMIT 0,6";
$sql_result=mysqli_query($sql_conn,$str_query);

$str = '';

if($sql_result){
    if(!mysqli_num_rows($sql_result)){ // if no result $sql_result = 0 = false , !0 = true;
        echo "Something Error. Please try again.";
        exit;
    }

    while($row=mysqli_fetch_assoc($sql_result)){
        $str .= '<div class="col-md-4 col-sm-6 portfolio-item">'; // no need <br> , is same to they stick together and next line
        $str .= '<a class="portfolio-link" data-toggle="modal" href="product.php?pid=';
        $str .= $row['id'] ;
        $str .= '">';
        $str .= '<div class="portfolio-hover">';
        $str .= '<div class="portfolio-hover-content">';
        $str .= '<i class="fas fa-plus fa-3x"></i>';
        $str .= '</div>';
        $str .= '</div>';
        $str .= '<img class="img-fluid imgproperties" src="';
        $str .= $row["picture"] ;
        $str .= '" alt="">';
        $str .= '</a>';
        $str .= '<div class="portfolio-caption prodtitle">';
        $str .= '<h4>';
        $str .= $row["name"];
        $str .= '</h4>';
        $str .= '<p class="text-muted"> RM ';
        $str .= $row["price"];
        $str .= '</p>';
        $str .= '</div>';
        $str .= '</div>';
    }
}
?>