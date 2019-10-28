<?php
$conn = new mysqli("localhost", "egyjuba", "HM_hezfa@13194", "cafeteria-system");

$result = $conn->query("SELECT * FROM category");

$nr = $result->num_rows;
$items_per_page = 3;
$total_no_of_pages = ceil($nr / $items_per_page);
$page = 1;
if(isset($_GET['page']))
$page = $_GET['page'];

$offset = ($page-1) * $items_per_page;

$sliced_result = array();

while($row = $result->fetch_assoc()) 
array_push($sliced_result , $row);

// pri  nt_r($sliced_result);
for($i= $offset ; $i<$items_per_page + $offset; $i++){
    echo $sliced_result[$i]['id']." : ".$sliced_result[$i]['category_name'].'<br/>';
    
}
$conn->close();
?>
<style>
a{
    text-decoration: none;
}


</style>
<div class='pagination'>
     <a href="pagaing-test.php?page=<?php echo ($page-1);?>" style ="<?php if($page == 1) echo 'pointer-events: none'; else echo '""'; ?>" > < </a>
     <span> <?php echo " " .($page) . " ";?> </span>
    <a href="pagaing-test.php?page=<?php echo ($page+1);?>" style ="<?php if($page == $total_no_of_pages) echo 'pointer-events: none'; else echo '""'; ?>" > > </a> 
</div>
    
