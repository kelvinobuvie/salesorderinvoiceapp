<?php
//session_start();
include_once('function.php');
/*
if($_SESSION['userID'] == ''){
  header('Location: login.php');
}
 
 $userID = $_SESSION['userID'];
*/
if(isset($_GET['invoicenumber'])){
  $ordernumber = filter_var($_GET['invoicenumber'], FILTER_SANITIZE_STRING);
}else{
  header('location: ./invoicelist.php');
}

$filename = $ordernumber.".pdf";

$invoicestmt = $conn->prepare('SELECT * FROM salesorder, customers, staffs, states, carriers WHERE salesorder.salesOrderOwner = customers.customerID AND salesorder.assignedTo = staffs.userID AND customers.customerState = states.stateID AND salesorder.salesOrderCarrier = carriers.carrierID AND salesorder.salesOrderStatus = 1 AND salesorder.invoiceNumber = :invoiceNumber LIMIT 1');
$invoicestmt->bindParam(':invoiceNumber', $ordernumber, PDO::PARAM_STR);
$invoicestmt->execute();
$result = $invoicestmt->fetch(PDO::FETCH_OBJ);


$itemstmt = $conn->prepare('SELECT * FROM salesorder, customers, staffs, items WHERE salesorder.salesOrderOwner = customers.customerID AND salesorder.assignedTo = staffs.userID AND salesorder.itemName = items.itemID AND salesorder.salesOrderStatus = 1 AND salesorder.invoiceNumber = :invoiceNumber');
$itemstmt->bindParam(':invoiceNumber', $ordernumber, PDO::PARAM_STR);
$itemstmt->execute();
$results = $itemstmt->fetchAll(PDO::FETCH_OBJ);


require_once __DIR__ . '/vendor/autoload.php';

$mpdf = new \Mpdf\Mpdf();

//Create PDF content
$data = '';

//Add data to PDF
$data .= '<div style="border: 1px solid red; border-radius: 5px; padding: 10px;">';
$data .= '<table border="0" width="100%">';
$data .= '<tr>';
$data .= '<td>';
$data .= '<h1 style="color:red; font-size:14px;">INVOICE NO: '.$ordernumber.'</h1>';
$data .= '<h1 style="color:red; font-size:14px;">PO NO: '.$result->purchaseOrderNumber.'</h1>';
$data .= '</td>';
$data .= '<td>';
$data .= '<h6>DUE DATE: '.$result->dueDate.'</h6><h6>PRINT DATE: '.date("d-m-Y").'</h6>';
$data .= '</td>';
$data .= '</tr>';
$data .= '<tr><td>&nbsp;</td></tr>';
$data .= '<tr>';
$data .= '<td>'.strtoupper($result->salesOrderDescription). "<p><b>DELIVERY :</b> ".$result->carrierDescription.'</p></td>';
$data .= '</tr>';
$data .= '<tr><td>&nbsp;</td></tr>';
$data .= '<tr>';
$data .= '<td>';
$data .= '<h3>BILLING ADDRESS</h3>';
$data .= '<p>'.strtoupper($result->customerName).'</p>';
$data .= '<p>'.strtoupper($result->customerContactName).' ('.$result->customerContactNumber.')</p>';
$data .= '<p>'.$result->billingAddress.'</p>';
$data .= '<p>'.$result->customerCity.", ".$result->stateDescription.'</p>';
$data .= '</td>';
$data .= '<td>';
$data .= '<h3>SHIPPING ADDRESS</h3>';
$data .= '<p>'.strtoupper($result->customerName).'</p>';
$data .= '<p>'.strtoupper($result->customerContactName).' ('.$result->customerContactNumber.')</p>';
$data .= '<p>'.$result->shippingAddress.'</p>';
$data .= '<p>'.$result->customerCity.", ".$result->stateDescription.'</p>';
$data .= '</td>';
$data .= '</tr>';
$data .= '<tr>';
$data .= '<td>&nbsp;</td>';
$data .= '</td>';
$data .= '<tr>';
$data .= '<td colspan="2">';
$data .= '<table style="width:100%;" border="1">';
$data .= '<tr>';
$data .= '<th>SN</th><th>DESCRIPTION</th><th>QUANTITY</th><th>UNIT PRICE</th><th>TOTAL</th>';
$data .= '</tr>';
$i = 0;
$subtotal = 0;
foreach($results as $row){ 
  $i++;
  $subtotal += $row->salesTotal;
$data .= '<tr>';
$data .= '<td>'.$i.'</td>';
$data .= '<td>'.$row->itemDescription.'</td>';
$data .= '<td>'.$row->itemQuantity.'</td>';
$data .= '<td>'.$row->itemUnitPrice.'</td>';
$data .= '<td>'.$row->salesTotal.'</td>';
$data .= '</tr>';
}
$data .= '<tr>';
$data .= '<td colspan="4" style="text-align: right;"><b>SUB-TOTAL</b></td>';
$data .= '<td>'.$subtotal.'</td>';
$data .= '</tr>';
$data .= '<tr>';
$data .= '<td colspan="4" style="text-align: right;"><b>ADJUSTMENT</b></td>';
$data .= '<td>'.$result->salesAdjustment.'</td>';
$data .= '</tr>';
$data .= '<tr>';
$total = $subtotal - $result->salesAdjustment;
$data .= '<td colspan="4" style="text-align: right;"><b>TOTAL</b></td>';
$data .= '<td>'.$total.'</td>';
$data .= '</tr>';
$data .= '<tr>';
$data .= '<td colspan="4" style="text-align: right;"><b>TAX</b></td>';
$data .= '<td>'.$result->salesOrderTax.'</td>';
$data .= '</tr>';
$data .= '<tr>';
$data .= '<td colspan="4" style="text-align: right;"><b>COMMISSION</b></td>';
$data .= '<td>'.$result->salesCommission.'</td>';
$data .= '</tr>';
$data .= '<tr>';
$grandtotal = $total - ($result->salesOrderTax + $result->salesCommission);
$data .= '<td colspan="4" style="text-align: right;"><b>GRAND TOTAL</b></td>';
$data .= '<td>'.$grandtotal.'</td>';
$data .= '</tr>';
$data .= '</table>';
$data .= '</td>';
$data .= '</tr>';
$data .= '<tr>';
$data .= '<td>&nbsp;</td>';
$data .= '</tr>';
$data .= '<tr>';
$data .= '<td colspan="2" style="text-align: right;">'.$result->additionalInformation.'</td>';
$data .= '</tr>';
$data .= '<tr>';
$data .= '<td colspan="2" style="text-align: right; font-size:8; color: red;"><i>Thanks for doing business with us!<i></td>';
$data .= '</tr>';
$data .= '</table>';
$data .= '</div>';

//Write PDF
$mpdf->WriteHTML($data);

//Output to the browser
$mpdf->Output($filename, 'D');

?>