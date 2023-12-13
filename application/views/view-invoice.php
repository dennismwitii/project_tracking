<?php
$project_title = $invoice['project_title'] !=''?'for project -'.$invoice['project_title']:'';
// create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information

$pdf->SetTitle(!empty($this->lang->line('label_invoice')) ? $this->lang->line('label_invoice') : 'Invoice - '.get_compnay_title());
$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, 'Invoice '.$project_title);

// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set some language-dependent strings (optional)
if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
    require_once(dirname(__FILE__).'/lang/eng.php');
    $pdf->setLanguageArray($l);
}

// ---------------------------------------------------------

// set font


// add a page
$pdf->AddPage();
$pdf->Ln(5);
$pdf->SetFont('helvetica', 'B', 11, '', true);
// set color for background
$pdf->SetFillColor(255, 255, 255);

$pdf->SetTextColor(0, 0, 0);

$pdf->SetFont('helvetica', 'B', 11, '', true);
$pdf->SetXY(20,40);
$pdf->Multicell(0,0,!empty($this->lang->line('label_billing_details')) ? $this->lang->line('label_billing_details') : 'Billing Details', 0, 'L', 1, 1, '', '', true, 0, false, true, 0);
$pdf->SetFont('helvetica', '', 11, '', true);
$pdf->SetXY(20,47);
$pdf->Multicell(0,0,$invoice['name']."\n".$invoice['address']."\n".$invoice['city'].', '.$invoice['state'].', '.$invoice['country'].', '.$invoice['zip_code']."\n".'Mo. '.$invoice['contact'], 0, 'L', 1, 1, '', '', true, 0, false, true, 0);
$pdf->SetFont('helvetica', 'B', 11, '', true);
$pdf->SetXY(23,40);
$pdf->Multicell(147,0,!empty($this->lang->line('label_invoice_no')) ? $this->lang->line('label_invoice_no') : 'Invoice No', 0, 'R', 1, 1, '', '', true, 0, false, true, 0);
$pdf->SetFont('helvetica', '', 11, '', true);
$pdf->SetXY(150,46);
$pdf->Multicell(0,0,"#INVOC - ".$invoice['id'], 0, 'L', 1, 1, '', '', true, 0, false, true, 0);
$pdf->SetFont('helvetica', 'B', 11, '', true);
$pdf->SetXY(150,53);
$pdf->Multicell(0,0,!empty($this->lang->line('label_invoice_date')) ? $this->lang->line('label_invoice_date') : 'Invoice Date', 0, 'L', 1, 1, '', '', true, 0, false, true, 0);
$pdf->SetXY(21,25);
if($invoice['status']==1){
    $color = array(40, 167, 69);
    $statustext = !empty($this->lang->line('label_fully_paid')) ? $this->lang->line('label_fully_paid') : 'FULLY PAID';
}elseif($invoice['status']==2){
    $color = array(255,165,0);
    $statustext = !empty($this->lang->line('label_partially_paid')) ? $this->lang->line('label_partially_paid') : 'PARTIALLY PAID';
}elseif($invoice['status']==3){
    $color = array(58,186,244);
    $statustext = !empty($this->lang->line('label_draft')) ? $this->lang->line('label_draft') : 'DRAFT';
}elseif($invoice['status']==4){
    $color = array(252, 84, 75);
    $statustext = !empty($this->lang->line('label_cancelled')) ? $this->lang->line('label_cancelled') : 'CANCELLED';
}elseif($invoice['status']==5){
    $color = array(0, 0, 255);
    $statustext = !empty($this->lang->line('label_due')) ? $this->lang->line('label_due') : 'DUE';
}else{
    $color = array(169,169,169);
    $statustext = 'N/A';
}
// echo $text_color;
$pdf->SetLineStyle(array('width' => 0.5, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => $color));
if($invoice['status']==1){
    $pdf->SetTextColor(40,167,69);
}elseif($invoice['status']==2){
    $pdf->SetTextColor(255,165,0);
}elseif($invoice['status']==3){
    $pdf->SetTextColor(58,186,244);
}elseif($invoice['status']==4){
    $pdf->SetTextColor(252, 84, 75);
}elseif($invoice['status']==5){
    $pdf->SetTextColor(0, 0, 255);
}else{
    $pdf->SetTextColor(169,169,169);
}
$pdf->MultiCell(40, 4, $statustext, 1, 'C', 1, 0);
$pdf->SetTextColor(0,0,0);
$pdf->SetFont('helvetica', '', 11, '', true);
$pdf->SetXY(150,59);
// $status = 
$pdf->Multicell(0,0,date("d-M-Y H:i:s", strtotime($invoice['created_on'])), 0, 'L', 1, 1, '', '', true, 0, false, true, 0);
$y = $pdf->GetY();
$pdf->SetFont('helvetica', 'B', 11, '', true);

$pdf->SetXY(90,$y+5);

$pdf->Multicell(35,0,!empty($this->lang->line('label_invoice_summary')) ? $this->lang->line('label_invoice_summary') : 'Invoice Summary', 0, 'J', 1, 1, '', '', true, 0, false, true, 0);
$html = '<table border="0" cellpadding="5">';
$html .= '<thead>
 <tr style="background-color: #f5f5f5;color:#000000">
  <td align="center" width="140"><b>Product / Service</b></td>
  <td align="center"> <b>Quantity</b></td>
  <td align="center"><b>Unit</b></td>
  <td align="center"><b>Rate('.get_currency_symbol().')</b></td>
  <td align="center"><b>Tax</b></td>
  <td align="center"><b>Amount('.get_currency_symbol().')</b></td>
 </tr>
</thead>';
$sub_total = 0;
$total_tax = 0;
    foreach($invoice_items as $invoice_item){
        $amount = $invoice_item['rate']*$invoice_item['qty'];
        $sub_total += $amount;
        $total_tax += $amount / 100 * $invoice_item['tax_percentage'];
        $unit = !empty($invoice_item['unit_title'])?$invoice_item['unit_title']:"-";
        $tax_title = !empty($invoice_item['tax_title'])?$invoice_item['tax_title'].' ('.$invoice_item['tax_percentage'].'%)':"N/A";
    $html .= '<tr>
    <td align="center" width="140">'.$invoice_item['title'].'</td>
    <td align="center">'.$invoice_item['qty'].'</td>
    <td align="center">'.$unit.'</td>
    <td align="center">'.$invoice_item['rate'].'</td>
    <td align="center">'.$tax_title.'</td>
    <td align="center">'.number_format((float)$amount, 2).'</td>
   </tr>';
}
$html .= '</table>';

$pdf->SetXY(8,80);
$pdf->SetFont('helvetica', '', 11, '', true);
$pdf->writeHTML($html, true, 0, true, 0);

$y = $pdf->GetY();
$pdf->SetFont('helvetica', '', 11, '', true);
$pdf->SetXY(20,$y+2);
$pdf->Multicell(146,0,!empty($this->lang->line('label_sub_total')) ? $this->lang->line('label_sub_total') : 'Sub Total'.'('.get_currency_symbol().')', 0, 'R', 1, 1, '', '', true, 0, false, true, 0);
$pdf->SetFont('helvetica', 'B', 12);
$pdf->SetXY(40,$y+2);
$pdf->Multicell(155,0,number_format((float)$sub_total, 2), 0, 'R', 1, 1, '', '', true, 0, false, true, 0);
$pdf->SetXY(40,$y+8);
$pdf->SetFont('helvetica', '', 11, '', true);
$pdf->Multicell(126,0,!empty($this->lang->line('label_total_tax')) ? $this->lang->line('label_total_tax') : 'Total Tax'.'('.get_currency_symbol().')', 0, 'R', 1, 1, '', '', true, 0, false, true, 0);
$pdf->SetFont('helvetica', 'B', 12);
$pdf->SetXY(15,$y+8);
$pdf->Multicell(180,0,number_format((float)$total_tax, 2), 0, 'R', 1, 1, '', '', true, 0, false, true, 0);
$pdf->SetXY(15,$y+14);
$pdf->SetFont('helvetica', '', 11, '', true);
$pdf->Multicell(153,0,!empty($this->lang->line('label_final_total')) ? $this->lang->line('label_final_total') : 'Final Total'.'('.get_currency_symbol().')', 0, 'R', 1, 1, '', '', true, 0, false, true, 0);
$pdf->SetFont('helvetica', 'B', 12);
$pdf->SetXY(42,$y+14);
$pdf->Multicell(153,0,number_format((float)$sub_total+$total_tax, 2), 0, 'R', 1, 1, '', '', true, 0, false, true, 0);
$y = $pdf->GetY();
$pdf->SetFont('helvetica', 'B', 11, '', true);
$pdf->SetXY(90,$y+5);
$pdf->Multicell(37,0,!empty($this->lang->line('label_payment_summary')) ? $this->lang->line('label_payment_summary') : 'Payment Summary', 0, 'J', 1, 1, '', '', true, 0, false, true, 0);
if(!empty($payments)){
    $html = '<table border="0" cellpadding="5">';
    $html .= '<thead>
     <tr style="background-color: #f5f5f5;color:#000000">
     <td align="center"><b>#</b></td>
     <td align="center"><b>Amount(₹)</b></td>
      <td align="center"> <b>Payment Mode</b></td>
      <td align="center"><b>Note</b></td>
      <td align="center"><b>Payment Date</b></td>
      <td align="center"><b>Amount Left('.get_currency_symbol().')</b></td>
     </tr>
    </thead>';
    $i = 1;
    $paid_amount = 0;
    $pdf->SetFont('helvetica', '', 11, '', true);
    foreach ($payments as $payment) {
        $paid_amount += $payment['amount'];
        $amount_left = $payment['total_amount'] - $paid_amount;
        $html .= '<tr>
        <td align="center">'.$i.'</td>
        <td align="center">'.number_format((float)$payment['amount'], 2).'</td>
        <td align="center">'.$payment['payment_mode'].'</td>
        <td align="center">'.$payment['note'].'</td>
        <td align="center">'.date("d-M-Y H:i:s", strtotime($payment['payment_date'])).'</td>
        <td align="center">'.number_format((float)$amount_left, 2).'</td>
       </tr>';
       $i++;
    }
    $html .= '</table>';
    $pdf->SetXY(15,$y+15);
    $pdf->writeHTML($html, true, 0, true, 0);
}else{
    $pdf->SetFont('helvetica', '', 11, '', true);
    $pdf->SetXY(89,$y+15);
    $pdf->Multicell(40,10,!empty($this->lang->line('label_no_payments_found')) ? $this->lang->line('label_no_payments_found') : 'No payments found!', 0, 'J', 1, 1, '', '', true, 0, false, true, 0);
}









// ---------------------------------------------------------

//Close and output PDF document
$pdf->Output(get_compnay_title().'-INVOC-'.$invoice['id'].'.pdf','I');

//============================================================+
// END OF FILE
//============================================================+