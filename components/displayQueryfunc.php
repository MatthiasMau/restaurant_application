<?php 

function generateTable($sqlSelect, $dataType=null, $columnName=null) {
    require('db_connect.php');
    if(null !== $dataType && null !== $columnName){
    $stmt = $connect->prepare($sqlSelect);
    $stmt->bind_param($dataType, $columnName);
    $work = $stmt->execute();
    $result = $stmt->get_result();
    } else if ($dataType == null && $columnName == null) {
    $stmt = $connect->prepare($sqlSelect);
    $work = $stmt->execute();
    $result = $stmt->get_result();
    var_dump($result);
}
   $html = "";
   $i = 0;
   $header = "<tr>";
   $body = "";
   while($row = $result->fetch_assoc()) {
      $i += 1;
      $body .= "<tr>\n";
      foreach($row as $column => $value) {
          if ($i == 1){
              $header .= "<th>$column</th>\n";
          } 
         $body .= "<td>$value</td>\n";
        }
      $body .= "</tr>\n";
   }
   $header .= "</tr>\n";
   $html .= "<table class=' col-8 mt-2 table table-striped'> $header $body</table>";
   return $html;
}

?>

<!-- if(mysqli_num_rows($result) > 0){
            //run them through while loop, for as many rows as there are
            while($fam = mysqli_fetch_array($answer, MYSQLI_ASSOC)){
            while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
               
                $tbody .= "<tr>
                <td><strong>This booking was made by: </strong><br>". $fam['last_name'] . " <strong>user ID: </strong> ".$row['fk_user']." </td>
                <td><img class='w-50' src= '../pictures/".$row['picture']. ".jfif'>".$row['picture']."</td>
                <td>" .$row['time']."</td>
               <td>" .$row['date']."</td>
               <td><a href='update.php?id=".$row['id']."'><button class='btn btn-primary btn-sm' type='button'>Edit</button></a>
               <a href='delete.php?id=".$row['id']."'><button class='btn btn-danger btn-sm' type='button'>Delete</button></a></td>
               </tr>";
       };
            }
    } 
else {
    $tbody =  "<tr><td colspan='5'><center>No Data Available </center></td></tr>";
 } -->