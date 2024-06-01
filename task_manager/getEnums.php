<?php 

function getEnumValues($conn, $table, $column) {
  $sql = "SHOW COLUMNS FROM $table WHERE Field = :column";
  $stmt = $conn->prepare($sql);
  $stmt->bindParam(':column', $column);
  $stmt->execute();
  $columnInfo = $stmt->fetch(PDO::FETCH_ASSOC);

  if ($columnInfo) {
      preg_match_all("/'([^']+)'/", $columnInfo['Type'], $matches);
      return $matches[1];
  }
  return [];
} 
?>