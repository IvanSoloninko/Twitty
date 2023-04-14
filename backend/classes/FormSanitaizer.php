<?php
class FormSanitaizer{
    
 public static function formSanitaizerString($date){
    $date = trim(strip_tags($date));
    $date = htmlspecialchars($date);
    return $date;
 }

 public static function formSanitaizerName($date){
    $date = trim(strip_tags($date));
    $date = htmlspecialchars($date);
    $date = strtolower($date);
    $date = ucfirst($date);

    return $date;
 }

}

?>