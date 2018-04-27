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
  isset($_POST['txtSearchClient'])? $txtSearchClient = $_POST['txtSearchClient'] : $txtSearchClient = "";
  if(!$txtSearchClient) {
    isset($_REQUEST['txtSearchClient'])? $txtSearchClient = $_REQUEST['txtSearchClient'] : $txtSearchClient = "";
  }

  isset($_POST['txtSearchStock'])? $txtSearchStock = $_POST['txtSearchStock'] : $txtSearchStock = "";
  if(!$txtSearchStock) {
    isset($_REQUEST['txtSearchStock'])? $txtSearchStock = $_REQUEST['txtSearchStock'] : $txtSearchStock = "";
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
  <script src="js/utils.js" type="text/javascript"></script>
  <script src="js/searchClient.js" type="text/javascript"></script>
  <script src="js/searchStock.js" type="text/javascript"></script>

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
      <br />
      <div class="displayPane">
        <div class="displayPaneCaption">Search Stock:</div>
        <div>
          <input name="txtSearchStock" id="txtSearchStock" placeholder="Search Client"
          style="width: 115px">
          <button type="button" id="btnSearchStock">Search</button>
        </div>
        <div style="margin-top: <?PHP echo $fieldSpacer; ?>">
          <div style="display: inline-block; width: 24%">
            <label for=""><strong>Stock ID</strong></label>
            <br />
            <input name="txtStockId" id="txtStockId" value="" title="Stock ID" disabled="disabled" style="width: 95%;">
          </div>
          <div style="display: inline-block; width: 24%">
            <label for=""><strong>Name</strong></label>
            <br />
            <input name="txtStockName" id="txtStockName" value="" title="Name" disabled="disabled" style="width: 95%;">
          </div>
          <div style="display: inline-block; width: 24%">
            <label for=""><strong>Price</strong></label>
            <br />
            <input name="txtStockPrice" id="txtStockPrice" value="" title="Price" disabled="disabled" style="width: 95%;">
          </div>
          <div style="display: inline-block; width: 15%">
            <label for=""><strong>Quantity</strong></label>
            <br />
            <input name="txtStockQty" id="txtStockQty" value="" title="Quantity" type="number" max="0" min="0" style="width: 50%;">
          </div>
          <div style="display: inline-block; width: 10%">
            <input type="button" class="addItem" value="Add Item"></input>
          </div>
        </div>
      </div>
      <br />
      <table style="width: calc(100% - 15px);border: #cccccc solid 1px" id="itemsList">
        <thead>
          <tr style="background: #eeeeee">
            <td style="width: 105px;border-left: #cccccc solid 1px"><b>Stock ID</b></td>
            <td style="border-left: #cccccc solid 1px"><b>Name</b></td>
            <td style="width: 130px;text-align: right;border-left: #cccccc solid 1px"><b>Price</b></td>
            <td style="width: 80px;text-align: right;border-left: #cccccc solid 1px"><b>Quantity</b></td>
            <td style="width: 80px;text-align: right;border-left: #cccccc solid 1px"><b>Amout</b></td>
            <td style="width: 80px;text-align: right;border-left: #cccccc solid 1px"><b>#</b></td>
          </tr>
        </thead>
        <tbody>
          <tr class="hl">
          </tr>
        </tbody>
        <tfoot>
          <tr style="border-top: #ccc 1px solid;">
            <td colspan="4" style="text-align: right;">Total Amount:</td>
            <td colspan="2" class="totalAmount"  style="text-align: left; font-weight: bold;"></td>
          </tr>
        </tfoot>
      </table>
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
