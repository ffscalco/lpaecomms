<?PHP
  $authChk = true;
  require('app-lib.php');
  isset($_REQUEST['sid'])? $sid = $_REQUEST['sid'] : $sid = "";
  if(!$sid) {
    isset($_POST['sid'])? $sid = $_POST['sid'] : $sid = "";
  }
  isset($_REQUEST['a'])? $action = $_REQUEST['a'] : $action = "";
  if(!$action) {
    isset($_POST['a'])? $action = $_POST['a'] : $action = "";
  }
  isset($_POST['txtSearch'])? $txtSearch = $_POST['txtSearch'] : $txtSearch = "";
  if(!$txtSearch) {
    isset($_REQUEST['txtSearch'])? $txtSearch = $_REQUEST['txtSearch'] : $txtSearch = "";
  }

  if($action == "delRec") {
    $query =
      "UPDATE lpa_invoices SET
         lpa_inv_status = 'D'
       WHERE
         lpa_inv_no = '$sid' LIMIT 1
      ";
    openDB();
    $result = $db->query($query);
    if($db->error) {
      printf("Errormessage: %s\n", $db->error);
      exit;
    } else {
      header("Location: sales.php?a=recDel&txtSearch=$txtSearch");
      exit;
    }
  }

  isset($_POST['txtInvNo'])? $invoiceID = $_POST['txtInvNo'] : $invoiceID = gen_ID();
  isset($_POST['txtStockName'])? $stockName = $_POST['txtStockName'] : $stockName = "";
  isset($_POST['txtStockDesc'])? $stockDesc = $_POST['txtStockDesc'] : $stockDesc = "";
  isset($_POST['txtStockOnHand'])? $stockOnHand = $_POST['txtStockOnHand'] : $stockOnHand = "0";
  // isset($_POST['txtStockImage'])? $stockImage = $_POST['txtStockImage'] : $stockImage = "";
  isset($_POST['txtStockPrice'])? $stockPrice = $_POST['txtStockPrice'] : $stockPrice = "0.00";
  isset($_POST['txtStatus'])? $stockStatus = $_POST['txtStatus'] : $stockStatus = "";
  $mode = "insertRec";
  if($action == "updateRec") {
    $query =
      "UPDATE lpa_invoices SET
         lpa_inv_no = '$invoiceID',
         lpa_stock_name = '$stockName',
         lpa_stock_desc = '$stockDesc',
         lpa_stock_onhand = '$stockOnHand',
         lpa_stock_price = '$stockPrice',
         lpa_stock_status = '$stockStatus'
       WHERE
         lpa_inv_no = '$sid' LIMIT 1
      ";
     openDB();
     $result = $db->query($query);
     if($db->error) {
       printf("Errormessage: %s\n", $db->error);
       exit;
     } else {
         header("Location: sales.php?a=recUpdate&txtSearch=$txtSearch");
       exit;
     }
  }
  if($action == "insertRec") {
    $query =
      "INSERT INTO lpa_invoices (
         lpa_inv_no,
         lpa_stock_name,
         lpa_stock_desc,
         lpa_stock_onhand,
         lpa_stock_price,
         lpa_stock_status
       ) VALUES (
         '$invoiceID',
         '$stockName',
         '$stockDesc',
         '$stockOnHand',
         '$stockPrice',
         '$stockStatus'
       )
      ";
    openDB();
    $result = $db->query($query);
    if($db->error) {
      printf("Errormessage: %s\n", $db->error);
      exit;
    } else {
      header("Location: sales.php?a=recInsert&txtSearch=".$invoiceID);
      exit;
    }
  }

  if($action == "Edit") {
    $query = "SELECT * FROM lpa_invoices WHERE lpa_inv_no = '$sid' LIMIT 1";
    $result = $db->query($query);
    $row_cnt = $result->num_rows;
    $row = $result->fetch_assoc();
    $invoiceID     = $row['lpa_inv_no'];
    $stockName   = $row['lpa_stock_name'];
    $stockDesc   = $row['lpa_stock_desc'];
    $stockOnHand = $row['lpa_stock_onhand'];
    $stockPrice  = $row['lpa_stock_price'];
    $stockStatus = $row['lpa_stock_status'];
    $mode = "updateRec";
  }
  build_header($displayName);
  build_navBlock();
  $fieldSpacer = "5px";
?>
  <script src="js/searchClient.js" type="text/javascript"></script>

  <div id="content">
    <div class="PageTitle">Invoice Record Management (<?PHP echo $action; ?>)</div>

    <form name="frmInvoiceRec" id="frmInvoiceRec" method="post" action="<?PHP echo $_SERVER['PHP_SELF']; ?>">
      <div class="displayPane">
        <label><strong>Invoice Number:</strong> <?PHP echo $invoiceID; ?></label>
        <input name="txtInvNo" id="txtInvNo" value="<?PHP echo $invoiceID; ?>" type="hidden">
      </div>
      <br />
      <div class="displayPane">
        <div class="displayPaneCaption">Search Client:</div>
        <div>
          <input name="txtSearchClient" id="txtSearchClient" placeholder="Search Client"
          style="width: 115px">
          <button type="button" id="btnSearchClient">Search</button>
        </div>
        <div style="margin-top: <?PHP echo $fieldSpacer; ?>">
          <div style="display: inline-block; width: 24%">
            <label for=""><strong>Client ID</strong></label>
            <br />
            <input name="txtClientId" id="txtClientId" value="" title="Client ID" disabled="disabled" style="width: 95%;">
          </div>
          <div style="display: inline-block; width: 24%">
            <label for=""><strong>Name</strong></label>
            <br />
            <input name="txtClientName" id="txtClientName" value="" title="Name" disabled="disabled" style="width: 95%;">
          </div>
          <div style="display: inline-block; width: 24%">
            <label for=""><strong>Address</strong></label>
            <br />
            <input name="txtClientAddress" id="txtClientAddress" value="" title="Address" disabled="disabled" style="width: 95%;">
          </div>
          <div style="display: inline-block; width: 24%">
            <label for=""><strong>Phone</strong></label>
            <br />
            <input name="txtClientPhone" id="txtClientPhone" value="" title="Phone" disabled="disabled" style="width: 95%;">
          </div>
        </div>
      </div>
      <div style="margin-top: <?PHP echo $fieldSpacer; ?>">
        <input name="txtStockName" id="txtStockName" placeholder="Stock Name" value="<?PHP echo $stockName; ?>" style="width: 400px;"  title="Stock Name">
      </div>
      <div style="margin-top: <?PHP echo $fieldSpacer; ?>">
        <textarea name="txtStockDesc" id="txtStockDesc" placeholder="Stock Description" style="width: 400px;height: 80px"  title="Stock Description"><?PHP echo $stockDesc; ?></textarea>
      </div>
      <div style="margin-top: <?PHP echo $fieldSpacer; ?>">
        <input name="txtStockOnHand" id="txtStockOnHand" placeholder="Stock On-Hand" value="<?PHP echo $stockOnHand; ?>" style="width: 90px;text-align: right"  title="Stock On-Hand">
      </div>
      <div style="margin-top: <?PHP echo $fieldSpacer; ?>">
        <input name="txtStockPrice" id="txtStockPrice" placeholder="Stock Price" value="<?PHP echo $stockPrice; ?>" style="width: 90px;text-align: right"  title="Stock Price">
      </div>
      <div style="margin-top: <?PHP echo $fieldSpacer; ?>">
        <div>Stock Status:</div>
        <input name="txtStatus" id="txtStockStatusActive" type="radio" value="a">
          <label for="txtStockStatusActive">Active</label>
        <input name="txtStatus" id="txtStockStatusInactive" type="radio" value="i">
          <label for="txtStockStatusInactive">Inactive</label>
      </div>
      <input name="a" id="a" value="<?PHP echo $mode; ?>" type="hidden">
      <input name="sid" id="sid" value="<?PHP echo $sid; ?>" type="hidden">
      <input name="txtSearch" id="txtSearch" value="<?PHP echo $txtSearch; ?>" type="hidden">
    </form>
    <div class="optBar">
      <button type="button" id="btnInvoiceSave">Save</button>
      <button type="button" onclick="navMan('sales.php')">Close</button>
      <?PHP if($action == "Edit") { ?>
      <button type="button" onclick="delRec('<?PHP echo $sid; ?>')" style="color: darkred; margin-left: 20px">DELETE</button>
      <?PHP } ?>
    </div>
  </div>
  <script>
    $("#btnInvoiceSave").click(function(){
        $("#frmInvoiceRec").submit();
    });
    function delRec(ID) {
      navMan("salesaddedit.php?sid=" + ID + "&a=delRec");
    }
    setTimeout(function(){
      $("#txtStockName").focus();
    },1);
  </script>
<?PHP
build_footer();
?>
