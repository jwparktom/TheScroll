<?php

  require_once '../db/db.php';

  class Getter{
    private function do_query($query, $rowFn){
      $data = [];
      if (!isset($rowFn) || empty($rowFn)) $rowFn = function($row, $_data){$_data[] = $row;}
      foreach ($pdo->query($query) as $row) $rowFn($row, $data);
      $row = null;
      return $data;
    }

    function roles(){
      return self::do_query(
        'SELECT * FROM Roles;',
        function($row, $data){$data[$row['name']] = $row;}
      );
    }

    function users(){
      return self::do_query(
        'SELECT * FROM Users;',
        function($row, $data){$data[$row['email']] = $row;}
      );
    }
  }

?>