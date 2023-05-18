<?php
  class User{
    private $pdo;
    public function __construct(){
        $this->pdo=Database::instance();

    }
  
    public function get($tableName, $columName=array(), $fields=array()){
      $targetColums=implode(', ',array_values($columName));
      $colums="";
      $i=1;
      foreach($fields as $name=>$value){
        $colums.="{$name}=:{$name}";
          if($i<count($fields)){
            $colums.=" AND ";
          }
        $i++;
      }
      
      $sql="SELECT {$targetColums} FROM {$tableName}  WHERE {$colums}";
        if($stmt=$this->pdo->prepare($sql)){
          foreach($fields as $key=>$values){
            $stmt->bindValue(":".$key,$values);
          }
          $stmt->execute();
          return $stmt->fetch(PDO::FETCH_OBJ);
        }
     }

  public function userData($userId){
        $stmt=$this->pdo->prepare('SELECT * FROM users WHERE user_id=:userId');
        $stmt->bindParam(":userId", $userId, PDO::PARAM_INT);
        $stmt->execute();
        $user=$stmt->fetch(PDO::FETCH_OBJ);
        if($stmt->rowCount()!=0){
            return $user;
        }else{
            return false;
        }
     }


     public function create($tableName, $fields=array()){
        $colums=implode(',' ,array_keys($fields));
        $values=':'.implode(', :' ,array_keys($fields));
        $sql="INSERT INTO {$tableName} ({$colums}) VALUES ({$values})";
          if($stmt=$this->pdo->prepare($sql)){
            foreach($fields as $key=>$values){
              $stmt->bindValue(":".$key,$values);
            }
            $stmt->execute();
            return $this->pdo->lastInsertId();
          }


     }

     
    
   }
?>