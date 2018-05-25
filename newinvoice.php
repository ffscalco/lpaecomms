<?PHP
  $authChk = true;
  $adminChk = true;
  require('app-lib.php');
  
  isset($_REQUEST['a'])? $action = $_REQUEST['a'] : $action = "";
  if(!$action) {
    isset($_POST['a'])? $action = $_POST['a'] : $action = "";
  }
  isset($_POST['txtSearch'])? $txtSearch = $_POST['txtSearch'] : $txtSearch = "";
  if(!$txtSearch) {
    isset($_REQUEST['txtSearch'])? $txtSearch = $_REQUEST['txtSearch'] : $txtSearch = "";
  }

  isset($_POST['txtClientID'])? $txtClientID = $_POST['txtClientID'] : $txtClientID = "";
  isset($_POST['txtClientName'])? $txtClientName = $_POST['txtClientName'] : $txtClientName = "";
  isset($_POST['txtClientAddress'])? $txtClientAddress = $_POST['txtClientAddress'] : $txtClientAddress = "";
  isset($_POST['txtClientPhone'])? $txtClientPhone = $_POST['txtClientPhone'] : $txtClientPhone = "";
  isset($_POST['txtSearchClient'])? $txtSearchClient = $_POST['txtSearchClient'] : $txtSearchClient = "";
  isset($_POST['txtSearchStock'])? $txtSearchStock = $_POST['txtSearchStock'] : $txtSearchStock = "";
  isset($_POST['txtStockID'])? $txtStockID= $_POST['txtStockID'] : $txtStockID = "";
  isset($_POST['txtStockName'])? $txtStockName= $_POST['txtStockName'] : $txtStockName = "";
  isset($_POST['txtStockPrice'])? $txtStockPrice= $_POST['txtStockPrice'] : $txtStockPrice = "";
  isset($_POST['txtQuantity'])? $txtQuantity= $_POST['txtQuantity'] : $txtQuantity = "";
  isset($_POST['noInvoice'])? $noInvoice= $_POST['noInvoice'] : $noInvoice = gen_ID();
  
  isset($_POST['hiddenClientID'])? $hiddenClientID= $_POST['hiddenClientID'] : $hiddenClientID = "";
  isset($_POST['hiddenClientName'])? $hiddenClientName= $_POST['hiddenClientName'] : $hiddenClientName = "";
  isset($_POST['hiddenClientAddress'])? $hiddenClientAddress= $_POST['hiddenClientAddress'] : $hiddenClientAddress = "";
  
  isset($_POST['stockIDs'])? $stockIDs= $_POST['stockIDs'] : $stockIDs = array();
  isset($_POST['stockNames'])? $stockNames= $_POST['stockNames'] : $StockNames =  array();
  isset($_POST['stockPrices'])? $stockPrices= $_POST['stockPrices'] : $stockPrices = array();
  isset($_POST['quantities'])? $quantities= $_POST['quantities'] : $quantities =  array();
  isset($_POST['values'])? $values= $_POST['values'] : $values = array();
  isset($_POST['numberItems'])? $numberItems= $_POST['numberItems'] : $numberItems = 0;
  isset($_POST['totalInvoice'])? $totalInvoice= $_POST['totalInvoice'] : $totalInvoice = 0;
  isset($_POST['hiddenStockID'])? $hiddenStockID= $_POST['hiddenStockID'] : $hiddenStockID = "";
  isset($_POST['hiddenStockName'])? $hiddenStockName= $_POST['hiddenStockName'] : $hiddenStockName = "";
  isset($_POST['hiddenStockPrice'])? $hiddenStockPrice= $_POST['hiddenStockPrice'] : $hiddenStockPrice = "";
  
  $mode = "";
  if($action == "addItem") {

   $stockIDs[]=$txtStockID;
   $stockNames[]=$txtStockName;
   $stockPrices[]=$txtStockPrice;
   $quantities[]=$txtQuantity;
   $values[]=$txtQuantity*$txtStockPrice;
   $numberItems++; 
   $totalInvoice+=$txtQuantity*$txtStockPrice;
   $txtStockID="";
   $txtStockName="";
   $txtStockPrice="";
   $txtQuantity="";
  }
  if($action == "searchClient") {
	$query = "SELECT * FROM lpa_clients WHERE lpa_client_ID = '$txtSearchClient' LIMIT 1";
	$result = $db->query($query);
	$row_cnt = $result->num_rows;
	if($row_cnt>0)
	{
		$row = $result->fetch_assoc();
		$txtClientID     = $row['lpa_client_ID'];
		$txtClientName   = $row['lpa_client_firstname']." ".$row['lpa_client_lastname'];
		$txtClientAddress = $row['lpa_client_address'];
		$txtClientPhone = $row['lpa_client_phone'];
		$hiddenClientID = $row['lpa_client_ID'];
		$hiddenClientName=$txtClientName;
		$hiddenClientAddress = $txtClientAddress;
		$txtSearchClient="";
	}
	else
	{
		$txtClientID     = "";
		$txtClientName   = "";
		$txtClientAddress = "";
		$txtClientPhone = "";
		$hiddenClientID = "";
		$hiddenClientName="";
		$hiddenClientAddress = "";
	}
  }

  if($action == "searchStock") {
    $query = "SELECT * FROM lpa_stock WHERE lpa_stock_ID = '$txtSearchStock' LIMIT 1";
    $result = $db->query($query);
    $row_cnt = $result->num_rows;
	if($row_cnt>0)
	{
		$row = $result->fetch_assoc();
		$txtStockID     = $row['lpa_stock_ID'];
		$txtStockName   = $row['lpa_stock_name'];
		$txtStockPrice   = $row['lpa_stock_price'];
		$hiddenStockID = $txtStockID;
		$hiddenStockName = $txtStockName;
		$hiddenStockPrice = $txtStockPrice;
		$txtSearchStock ="";
	}
	else
	{
		$txtStockID     = "";
		$txtStockName   = "";
		$txtStockPrice   = "";
		$hiddenStockID = "";
		$hiddenStockName = "";
		$hiddenStockPrice = "";
	}
  }
  
  if($action == "saveInvoice") {
	 $dateInvoice = date('Y-m-d h:i:s', time());
    $query =
      "INSERT INTO lpa_invoices (
		lpa_inv_no,
		lpa_inv_date,
		lpa_inv_client_ID,
		lpa_inv_client_name,
		lpa_inv_amount,
		lpa_inv_client_address,
		lpa_inv_status) 
		VALUES (
         '$noInvoice',
         '$dateInvoice',
         '$hiddenClientID',
         '$hiddenClientName',
         '$totalInvoice',
         '$hiddenClientAddress',
         'A'
       )
      ";
    openDB();
    $result = $db->query($query);
	for ($i = 0; $i < $numberItems; $i++) {
		$queryItems =
			"INSERT INTO lpa_invoice_items (
				lpa_invitem_inv_no,
				lpa_invitem_stock_ID,
				lpa_invitem_stock_name,
				lpa_invitem_qty,
				lpa_invitem_stock_price,
				lpa_invitem_stock_amount,
				lpa_inv_status) 
				VALUES (
				'$noInvoice',
				'$stockIDs[$i]',
				'$stockNames[$i]',
				'$quantities[$i]',
				'$stockPrices[$i]',
				'$values[$i]',
				'A')
				";
		 $result = $db->query($queryItems);
	}
	
    if($db->error) {
      printf("Errormessage: %s\n", $db->error);
      exit;
    } else {
      header("Location: sales.php?a=recInsert&txtSearch=".$txtSearch);
      exit;
    }
  }
  build_header($displayName);
  build_navBlock();
  $fieldSpacer = "5px";
?>

  <div id="content">
    <div class="PageTitle">New Invoice</div>

  <!-- Search Section Start -->
    <form name="frmNewInvoice" method="post"
          id="frmNewInvoice"
          action="<?PHP echo $_SERVER['PHP_SELF']; ?>">
	<div class="displayPane">
	<b>Invoice Number: </b> <?PHP echo $noInvoice; ?>
	<input type="hidden" name="noInvoice" id="noInvoice" value="<?PHP echo $noInvoice; ?>">
	</div>
      <div class="displayPane">
        <div class="displayPaneCaption">Search Client:</div>
        <div>
          <input name="txtSearchClient" id="txtSearchClient" placeholder="Client ID" value="<?PHP echo $txtSearchClient; ?>">
          <button type="button" id="btnSearchClient">Search Client</button>
        </div>
		<div>
		<table style="width: calc(100% - 15px);border: #cccccc solid 1px">
		  <td>
			<b>Cliente ID:</b> 
			<input name="txtClientID" id="txtClientID" readonly="true" value="<?PHP echo $txtClientID; ?>">
			<input type="hidden" name="hiddenClientID" id="hiddenClientID" value="<?PHP echo $hiddenClientID; ?>">
		  </td>
		  <td>
		  <b>Name:</b> 
			<input name="txtClientName" id="txtClientName" readonly="true" value="<?PHP echo $txtClientName; ?>">
			<input type="hidden" name="hiddenClientName" id="hiddenClientName" value="<?PHP echo $hiddenClientName; ?>">
		  </td>
		  <td>
		  <b>Address:</b> 
			<input name="txtClientAddress" id="txtClientAddress" readonly="true" value="<?PHP echo $txtClientAddress; ?>">
			<input type="hidden" name="hiddenClientAddress" id="hiddenClientAddress" value="<?PHP echo $hiddenClientAddress; ?>">
		  </td>
		  <td>
		  <b>Phone:</b> 
			<input name="txtClientPhone" id="txtClientPhone" readonly="true" value="<?PHP echo $txtClientPhone; ?>">
		  </td>
		  </table>
		</div>
      </div>
	   <div class="displayPane">
        <div class="displayPaneCaption">Search Stock:</div>
        <div>
          <input name="txtSearchStock" id="txtSearchStock" placeholder="Item ID" value="<?PHP echo $txtSearchStock; ?>">
          <button type="button" id="btnSearchStock">Search Item</button>
        </div>
		<div>
		<table style="width: calc(100% - 15px);border: #cccccc solid 1px">
		  <td>
			<b>Item ID:</b> 
			<input name="txtStockID" id="txtStockID"  value="<?PHP echo $txtStockID; ?>" readonly="true">
			<input name="hiddenStockID" id="hiddenStockID"  value="<?PHP echo $hiddenStockID; ?>" type="hidden">
		  </td>
		  <td>
		  <b>Name:</b> 
			<input name="txtStockName" id="txtStockName"  value="<?PHP echo $hiddenStockName; ?>" readonly="true">
			<input name="hiddenStockName" id="hiddenStockName"  value="<?PHP echo $hiddenStockName; ?>" type="hidden">
		  </td>
		  <td>
		  <b>Price:</b> 
			<input name="txtStockPrice" id="txtStockPrice" value="<?PHP echo $txtStockPrice; ?>" readonly="true">
			<input name="hiddenStockPrice" id="hiddenStockPrice"  value="<?PHP echo $hiddenStockPrice; ?>" type="hidden">
		  </td>
		  <td>
		  <b>Quantity:</b> 
			<input name="txtQuantity" placeholder="Quantity" id="txtQuantity" value="<?PHP echo $txtQuantity; ?>" size="4">
			<button type="button" id="btnAddItem">Add Item</button>
		  </td>
		  </table>
		</div>
      </div>
	  
	  <div>
	  <input type="hidden" name="numberItems" id="numberItems" value="<?PHP echo $numberItems; ?>">
	      <?PHP
      if($numberItems >= 1) { ?>
		<table style="width: calc(100% - 15px);border: #cccccc solid 1px">
			<tr style="background: #eeeeee">
			  <td style="width: 80px;border-left: #cccccc solid 1px"><b>Stock Code</b></td>
			  <td style="border-left: #cccccc solid 1px"><b>Stock Name</b></td>
			  <td style="width: 80px;text-align: right"><b>Price</b></td>
			  <td style="width: 80px;text-align: right"><b>Quantity</b></td>
			  <td style="width: 80px;text-align: right"><b>Value</b></td>
			</tr>
		 <?PHP
        for ($i = 0; $i < $numberItems; $i++) {
          ?>
          <tr class="hl">
            <td>
              <?PHP echo $stockIDs[$i]; ?>
			  <input type="hidden" name="stockIDs[]" value="<?PHP echo $stockIDs[$i] ?>">
            </td>
           <td>
              <?PHP echo $stockNames[$i]; ?>
			  <input type="hidden" name="stockNames[]" value="<?PHP echo $stockNames[$i] ?>">
            </td>
            <td style="text-align: right">
              <?PHP echo $stockPrices[$i]; ?>
			  <input type="hidden" name="stockPrices[]" value="<?PHP echo $stockPrices[$i] ?>">
            </td>
			<td style="text-align: right">
              <?PHP echo $quantities[$i]; ?>
			  <input type="hidden" name="quantities[]" value="<?PHP echo $quantities[$i] ?>">
            </td>
			<td style="text-align: right">
              <?PHP echo $values[$i]; ?>
			  <input type="hidden" name="values[]" value="<?PHP echo $values[$i] ?>">
            </td>
          </tr>
        <?PHP }
		?>
	  <tr class="hl">
           <td style="width: 80px;border-left: #cccccc solid 1px"><b>Total</b></td>
           <td colspan="3">
		   <td style="width: 80px;text-align: right">
				<b><?PHP echo $totalInvoice; ?></b>
				<input type="hidden" name="totalInvoice" value="<?PHP echo $totalInvoice; ?>">
		   </td>
          </tr>
      </table>
	  <?PHP }
		?>
    </div>
	
      <input type="hidden" name="a" id ="a" value="<?PHP echo $mode; ?>">
    </form>
	<div class="optBar">
      <button type="button" id="btnInvoiceSave">Save</button>
      <button type="button" onclick="navMan('sales.php')">Close</button>
    </div>
  </div>
  <script>
    var foundClient = "<?PHP echo $txtClientID; ?>";
	var foundStock = "<?PHP echo $txtStockID; ?>";
	var action = "<?PHP echo $action; ?>";
    if(action == "searchClient" && foundClient == "") {
      alert("Client Not Found!");
    }
	else
	{
		$("#btnSearchStock").disabled = false;
		$("#btnInvoiceSave").disabled = false;
		$("#btnAddItem").disabled = false;
	}
	if(action == "searchStock" && foundStock == "") {
      alert("Item Not Found!");
    }
	else
	{
		$("#btnAddItem").disabled = false;
	}
    $("#btnSearchClient").click(function(){
		if(document.getElementById("txtSearchClient").value == ""){
			 alert("Please type the Client ID!");
		}
		else{
			document.getElementById("a").value = "searchClient";
			$("#frmNewInvoice").submit();
		}
    });
    $("#btnSearchStock").click(function(){
		if(document.getElementById("txtSearchStock").value == ""){
			 alert("Please type the Stock ID!");
		}
		else
		{
			document.getElementById("a").value = "searchStock";
			$("#frmNewInvoice").submit();
		}
    });
	$("#btnAddItem").click(function(){
		if(document.getElementById("txtQuantity").value=="" || isNaN(document.getElementById("txtQuantity").value)
			|| document.getElementById("txtQuantity").value <=0 )
		{
			alert("Please type a valid quantity!");
		}
		else{
			document.getElementById("a").value = "addItem";
			$("#frmNewInvoice").submit();
		}
    });
	$("#btnInvoiceSave").click(function(){
		if(foundClient=="")
		{
			alert("Please search a client for the invoice!");
		}
		else{
			if(document.getElementById("numberItems").value <= 0)
				{
					alert("Please add at least one item to invoice!");
				}
				else{
					document.getElementById("a").value = "saveInvoice";
					$("#frmNewInvoice").submit();
				}
		}
    });
    setTimeout(function(){
      $("#txtSearchClient").focus();
    },1);
  </script>
<?PHP
build_footer();
?>