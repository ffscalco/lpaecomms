$(function() {
  $("button#btnSearchStock").on("click", function(event) {
    event.preventDefault();
    var searchTxt = $("input#txtSearchStock").val();

    if (searchTxt != "") {
      $.get("searchStock.php", { txtSearchStock: searchTxt } )
        .done(function( data ) {
          var result = JSON.parse(data);

          if ('no_results' in result) {
            cleanStockFields();
            alert("There is no Stock with ID: " + searchTxt)
          } else {
            $("input#txtStockId").val(result.id);
            $("input#txtStockName").val(result.name);
            $("input#txtStockPrice").val(result.price);
            $("input#txtStockQty").val("");
            $("input#txtStockQty").attr("max", result.onHand);

            if (parseInt(result.onHand) == 0) {
              alert("You don't have this item on hand.")
            }
          }
        });
    }
  })

  $("input#txtStockQty").on("blur", function() {
    if (parseInt($(this).val()) > parseInt($(this).attr("max"))) {
      $(this).val($(this).attr("max"));
    } else if (parseInt($(this).val()) < parseInt($(this).attr("min"))) {
      $(this).val($(this).attr("min"));
    }
  });

  $("input.addItem").on("click", function() {
    if ($("input#txtStockId").val() != "" && ($("input#txtStockQty").val() != "" && parseInt($("input#txtStockQty").val()) > 0)) {
      var trId = guidGenerator();
      var itemHtml = "<tr id='" + trId + "' class='h1'>";
      itemHtml += "<td>" + $("input#txtStockId").val() + "</td>";
      itemHtml += "<td>" + $("input#txtStockName").val() + "</td>";
      itemHtml += "<td style='text-align: right;'>" + $("input#txtStockPrice").val() + "</td>";
      itemHtml += "<td style='text-align: right;'>" + $("input#txtStockQty").val() + "</td>";
      var amout = parseFloat($("input#txtStockPrice").val()) * parseInt($("input#txtStockQty").val());
      itemHtml += "<td class='amount' style='text-align: right;'>" + amout.toFixed(2) + "</td>";
      itemHtml += "<td><input type='button' class='removeItemList' value='Delete' data-id='" + trId + "'></input></td>";
      itemHtml += "</tr>";
      $("table#itemsList tbody").append(itemHtml);

      var totalAmount = $("td.totalAmount").html();
      if (totalAmount == "") {
        totalAmount = 0;
      } else {
        totalAmount = parseFloat(totalAmount);
      }

      totalAmount += amout;

      $("td.totalAmount").html(totalAmount.toFixed(2));

      cleanStockFields();
      $("input#txtSearchStock").val("");
    } else {
      alert("Fill in a valid quantity");
    }
  });

  $("table#itemsList").on("click", "input.removeItemList", function() {
    $("table#itemsList tr#" + $(this).attr("data-id")).remove();

    var totalAmount = 0;
    $("table#itemsList td.amount").each(function() {
      totalAmount += parseFloat($(this).html());
    });

    $("td.totalAmount").html(totalAmount.toFixed(2));
  });
});


function cleanStockFields() {
  $("input#txtStockId").val("");
  $("input#txtStockName").val("");
  $("input#txtStockPrice").val("");
  $("input#txtStockQty").val("");
  $("input#txtStockQty").attr("max", 0);
}
