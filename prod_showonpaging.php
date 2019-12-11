<?php
include "connectdb.php";

$pagebtnlimit=5;
$prodshowperpage=9;
$str_query="SELECT * FROM product";
$sql_result=mysqli_query($sql_conn,$str_query);
$totalproducts=mysqli_num_rows($sql_result); // maybe there are 80 products, $totalproducts = 80
$totalpage=ceil($totalproducts/$prodshowperpage); // add on ceiling math function to make 4.1 become 5

//die($totalpage); stop here to print variable info

if($totalpage<=0){$totalpage=1;}
// $pagebtnlimit=5;
// $pagebtnshowto=($currpage*$pagebtnlimit<=$totalpage) ? ($currpage*$pagebtnlimit) : $totalpage;

$currpage=isset($_GET["page"]) ? $_GET["page"] : 1;
$sort=isset($_GET["sort"]) ? $_GET["sort"] : 0;
$url=($sort===0) ? "product_paging.php?" : ("product_paging.php?sort=" . $sort . "&&"); // how about the && and the ?
$getprdfrm=($currpage-1)*$prodshowperpage;

// switch case for sql
switch($sort){
    case 1: //A-Z
        $str_query="SELECT * FROM product ORDER BY `name` ASC LIMIT ". $getprdfrm .",".$prodshowperpage;
        break;
    case 2: //Z-A
        $str_query="SELECT * FROM product ORDER BY `name` DESC LIMIT ". $getprdfrm .",".$prodshowperpage;
        break;
    case 3: //L-H
        $str_query="SELECT * FROM product ORDER BY `price` ASC LIMIT ". $getprdfrm .",".$prodshowperpage;
        break;
    case 4: //H-L
        $str_query="SELECT * FROM product ORDER BY `price` DESC LIMIT ". $getprdfrm .",".$prodshowperpage;
        break;
    default: //none 
        $str_query="SELECT * FROM product LIMIT ". $getprdfrm .",".$prodshowperpage;
}

// $getprdfrm=($currpage-1)*$prodshowperpage;
// show products on each page with LIMIT
//$str_query="SELECT * FROM product LIMIT ". $getprdfrm .",".$prodshowperpage; // from GET the page num start
//die($str_query);
$sql_result=mysqli_query($sql_conn,$str_query);

$ctrprd = '';
$ctrbtn = '';
$ctrdrpdwn = '';
$cnt=0;
$targetpage=(ceil($currpage/$pagebtnlimit))*$pagebtnlimit; // for the page start from 
$pagebtnshowfrm=($currpage>$pagebtnlimit) ? (floor(($currpage-1)/$pagebtnlimit)*$pagebtnlimit+1) : 1; // get the zheng shu
$cnt=$pagebtnshowfrm;
$targetpage=(ceil($currpage/$pagebtnlimit))*$pagebtnlimit;
$pagebtnshowto=($targetpage < $totalpage) ? $targetpage : $totalpage;

//$url="product_paging.php?";

if($sql_result){
    if(mysqli_num_rows($sql_result) == 0){ // if no result $sql_result = 0 = false , !0 = true;
        echo "Something Error. Please try again.";
        exit;
    }

    $ctrdrpdwn .= '<div class="dropdown">';
    $ctrdrpdwn .= '<button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown"> Sort by </button>';
    $ctrdrpdwn .= '<div class="dropdown-menu">';
    $ctrdrpdwn .= '<a class="dropdown-item" href="product_paging.php?sort=0"> None </a>';
    $ctrdrpdwn .= '<a class="dropdown-item" href="product_paging.php?sort=1"> A-Z </a>';
    $ctrdrpdwn .= '<a class="dropdown-item" href="product_paging.php?sort=2"> Z-A </a>';
    $ctrdrpdwn .= '<a class="dropdown-item" href="product_paging.php?sort=3"> L-H </a>';
    $ctrdrpdwn .= '<a class="dropdown-item" href="product_paging.php?sort=4"> H-L </a>';
    $ctrdrpdwn .= '</div>';
    $ctrdrpdwn .= '</div>';

    while($row=mysqli_fetch_assoc($sql_result)){
        $ctrprd .= '<div class="col-md-4">'; // no need <br> , is same to they stick together and next line
        $ctrprd .= '<div class="card mb-4 shadow-sm">';
        $ctrprd .= '<img class="thumbnailstyle" src="';
        $ctrprd .= $row['picture'];
        $ctrprd .= '">';
        $ctrprd .= '<div class="card-body ">';
        $ctrprd .= '<p class="card-text textcontroller">';
        $ctrprd .= $row['name'];
        $ctrprd .= '</p>';
        $ctrprd .= '<div class="d-flex justify-content-between align-items-center">';
        $ctrprd .= '<div class="btn-group">';
        $ctrprd .= '<button type="button" class="btn btn-sm btn-outline-secondary">View</button>';
        $ctrprd .= '<button type="button" class="btn btn-sm btn-outline-secondary">Edit</button>';
        $ctrprd .= '</div>';
        $ctrprd .= '<small class="text-muted"> RM ';
        $ctrprd .= $row['price'];
        $ctrprd .= '</small>';
        $ctrprd .= '</div>';
        $ctrprd .= '</div>';
        $ctrprd .= '</div>';
        $ctrprd .= '</div>';
    }

    if ($currpage > $pagebtnlimit){
        $ctrbtn .= '<a href="';
        $ctrbtn .= $url;
        $ctrbtn .= 'page=';
        $ctrbtn .= $pagebtnshowfrm-1;
        $ctrbtn .= '">';
        $ctrbtn .= '<button type="button" class="btn btn-outline-secondary">...</button>';
        $ctrbtn .= '</a>';
    }

    do{
        //$cnt++;
        $ctrbtn .= '<a href="';
        $ctrbtn .= $url;
        $ctrbtn .= 'page=';
        $ctrbtn .= $cnt;
        $ctrbtn .= '">';
        $ctrbtn .= '<button type="button" class="btn btn-outline-secondary">'; // css change padding font size
        $ctrbtn .= $cnt++;
        $ctrbtn .= '</button>';
        $ctrbtn .= '</a>';
    }while($cnt <= $pagebtnshowto);

    if ($pagebtnshowto < $totalpage){
        $ctrbtn .= '<a href="';
        $ctrbtn .= $url;
        $ctrbtn .= 'page=';
        $ctrbtn .= $pagebtnshowto+1;
        $ctrbtn .= '">';
        $ctrbtn .= '<button type="button" class="btn btn-outline-secondary">...</button>';
        $ctrbtn .= '</a>';
    }
}
?>