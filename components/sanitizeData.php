<?php 
function sanitizeData($var){
    $result = trim($var);
    $result = strip_tags($result);
    $result = htmlspecialchars($result);
    return $result;
}
?>