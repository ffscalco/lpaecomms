<?PHP
  $authChk = true;
  require('app-lib.php');

  $search = $_GET['txtSearchStock'];

  $query = "SELECT * FROM lpa_stock WHERE lpa_stock_ID = '$search' AND lpa_stock_status <> 'D' LIMIT 1";
  openDB();
  $result = $db->query($query);
  $row_cnt = $result->num_rows;

  if ($row_cnt >= 1) {
    $row = $result->fetch_assoc();
    $searchComplete = array(
      'id' => $row['lpa_stock_ID'],
      'name' => $row['lpa_stock_name'],
      'price' => $row['lpa_stock_price'],
      'onHand' => $row['lpa_stock_onhand']
    );
  } else {
    $searchComplete = array('no_results' => true);
  }

  echo json_encode($searchComplete);
?>
