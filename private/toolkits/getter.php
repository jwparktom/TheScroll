<?php

  require_once __DIR__.'/../db/db.php';

  class Getter{
    private $pdo;

    function __construct($pdo){
      $this->pdo = $pdo;
    }

    private function do_query($query, $rowFn){
      $data = [];
      if (!isset($rowFn) || empty($rowFn)) $rowFn = function($row, $_data){$_data[] = $row;};
      foreach ($this->pdo->query($query) as $row) $data = $rowFn($row, $data);
      $row = null;
      return $data;
    }

    private function do_query_prepared($query, $prepared, $rowFn){
      $data = [];
      if (!isset($rowFn) || empty($rowFn)) $rowFn = function($row, $_data){$_data[] = $row;};
      $stmt = $this->pdo->prepare($query);
      if ($stmt->execute($prepared)){
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach ($rows as $row) $data = $rowFn($row, $data);
      }
      $row = null;
      return $data;
    }

    function role($id){
      return self::do_query_prepared(
        'SELECT * FROM Roles WHERE id = ?;',
        [$id],
        function($row, $data){
          $data[$row['id']] = [];
          $ignore = ['id', 'is_super', 'time_updated', 'assigned'];
          foreach ($row as $key => $val){
            if (!in_array($key, $ignore) && $val == 1) $data[$row['id']][] = $key;
          }
          return $data;
        }
      );
    }

    function roles(){
      return self::do_query(
        'SELECT * FROM Roles;',
        function($row, $data){
          $_data = ['job' => []];
          $ignore = ['id', 'name', 'is_super', 'time_updated', 'assigned'];
          foreach ($ignore as $key){
            $_data[$key] = $row[$key];
          }
          foreach ($row as $key => $val){
            if (!in_array($key, $ignore) && $val == 1) $_data['job'][] = $key;
          }
          $data[$row['id']] = $_data;
          return $data;
        }
      );
    }

    function users(){
      return self::do_query(
        'SELECT * FROM Users;',
        function($row, $data){
          $data[$row['email']] = $row;
          return $data;
        }
      );
    }
  }

  $Getter = new Getter($pdo);

?>
