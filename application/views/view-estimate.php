<?php
// create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', true);

// set document information
// echo PDF_HEADER_LOGO;
$pdf->SetTitle(!empty($this->lang->line('label_estimate')) ? $this->lang->line('label_estimate') : 'Estimate - ' . get_compnay_title());
$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);

// set header and footer fonts
$pdf->setHeaderFont(array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

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
if (@file_exists(dirname(__FILE__) . '/lang/eng.php')) {
    require_once(dirname(__FILE__) . '/lang/eng.php');
    $pdf->setLanguageArray($l);
}
// add a page
$pdf->AddPage();

$pdf->Ln(5);
$pdf->SetFont('helvetica', 'B', 11, '', true);
// set color for background
$pdf->SetFillColor(255, 255, 255);

$pdf->SetTextColor(0, 0, 0);

$pdf->SetFont('helvetica', 'B', 11, '', true);
$pdf->SetXY(20, 40);
$pdf->Multicell(0, 0, !empty($this->lang->line('label_billing_details')) ? $this->lang->line('label_billing_details') : 'Billing Details', 0, 'L', 1, 1, '', '', true, 0, false, true, 0);
$pdf->SetFont('helvetica', '', 11, '', true);
$pdf->SetXY(20, 47);
$pdf->Multicell(0, 0, $estimate['name'] . "\n" . $estimate['address'] . "\n" . $estimate['city'] . ', ' . $estimate['state'] . ', ' . $estimate['country'] . ', ' . $estimate['zip_code'] . "\n" . 'Mo. ' . $estimate['contact'], 0, 'L', 1, 1, '', '', true, 0, false, true, 0);
$pdf->SetFont('helvetica', 'B', 11, '', true);
$pdf->SetXY(24, 40);
$pdf->Multicell(149, 0, !empty($this->lang->line('label_estimate_no')) ? $this->lang->line('label_estimate_no') : 'Estimate No', 0, 'R', 1, 1, '', '', true, 0, false, true, 0);
$pdf->SetFont('helvetica', '', 11, '', true);
$pdf->SetXY(150, 46);
$pdf->Multicell(0, 0, "#ESTMT - " . $estimate['id'], 0, 'L', 1, 1, '', '', true, 0, false, true, 0);
$pdf->SetFont('helvetica', 'B', 11, '', true);
$pdf->SetXY(150, 53);
$pdf->Multicell(0, 0, !empty($this->lang->line('label_estimate_date')) ? $this->lang->line('label_estimate_date') : 'Estimate Date', 0, 'L', 1, 1, '', '', true, 0, false, true, 0);
$pdf->SetXY(21, 25);
if ($estimate['status'] == 1) {
    $color = array(103, 119, 239);
    $statustext = !empty($this->lang->line('label_sent')) ? $this->lang->line('label_sent') : 'SENT';
} elseif ($estimate['status'] == 2) {
    $color = array(40, 167, 69);
    $statustext = !empty($this->lang->line('label_accepted')) ? $this->lang->line('label_accepted') : 'ACCEPTED';
} elseif ($estimate['status'] == 3) {
    $color = array(58, 186, 244);
    $statustext = !empty($this->lang->line('label_draft')) ? $this->lang->line('label_draft') : 'DRAFT';
} elseif ($estimate['status'] == 4) {
    $color = array(252, 84, 75);
    $statustext = !empty($this->lang->line('label_declined')) ? $this->lang->line('label_declined') : 'DECLINED';
} elseif ($estimate['status'] == 5) {
    $color = array(255, 193, 7);
    $statustext = !empty($this->lang->line('label_expired')) ? $this->lang->line('label_expired') : 'EXPIRED';
} else {
    $color = array(169, 169, 169);
    $statustext = 'N/A';
}
// echo $text_color;
$pdf->SetLineStyle(array('width' => 0.5, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => $color));
if ($estimate['status'] == 1) {
    $pdf->SetTextColor(103, 119, 239);
} elseif ($estimate['status'] == 2) {
    $pdf->SetTextColor(40, 167, 69);
} elseif ($estimate['status'] == 3) {
    $pdf->SetTextColor(58, 186, 244);
} elseif ($estimate['status'] == 4) {
    $pdf->SetTextColor(252, 84, 75);
} elseif ($estimate['status'] == 5) {
    $pdf->SetTextColor(255, 193, 7);
} else {
    $pdf->SetTextColor(169, 169, 169);
}
$pdf->MultiCell(40, 4, $statustext, 1, 'C', 1, 0);
$pdf->SetTextColor(0, 0, 0);
$pdf->SetFont('helvetica', '', 11, '', true);
$pdf->SetXY(150, 59);
// $status = 
$pdf->Multicell(0, 0, date("d-M-Y H:i:s", strtotime($estimate['created_on'])), 0, 'L', 1, 1, '', '', true, 0, false, true, 0);
$html = '<table border="0" cellpadding="5">';
$html .= '<thead>
 <tr style="background-color: #f5f5f5;color:#000000">
  <td align="center" width="140"><b>Product / Service</b></td>
  <td align="center"> <b>Quantity</b></td>
  <td align="center"><b>Unit</b></td>
  <td align="center"><b>Rate(' . get_currency_symbol() . ')</b></td>
  <td align="center"><b>Tax</b></td>
  <td align="center"><b>Amount(' . get_currency_symbol() . ')</b></td>
 </tr>
</thead>';
$sub_total = 0;
$total_tax = 0;
foreach ($estimate_items as $estimate_item) {
    $amount = $estimate_item['rate'] * $estimate_item['qty'];
    $sub_total += $amount;
    $total_tax += $amount / 100 * $estimate_item['tax_percentage'];
    $unit = !empty($estimate_item['unit_title']) ? $estimate_item['unit_title'] : "-";
    $tax_title = !empty($estimate_item['tax_title']) ? $estimate_item['tax_title'] . ' (' . $estimate_item['tax_percentage'] . '%)' : "N/A";
    $html .= '<tr>
    <td align="center" width="140">' . $estimate_item['title'] . '</td>
    <td align="center">' . $estimate_item['qty'] . '</td>
    <td align="center">' . $unit . '</td>
    <td align="center">' . $estimate_item['rate'] . '</td>
    <td align="center">' . $tax_title . '</td>
    <td align="center">' . number_format((float)$amount, 2) . '</td>
   </tr>';
}
$html .= '</table>';

$pdf->SetXY(8, 80);
$pdf->writeHTML($html, true, 0, true, 0);
$y = $pdf->GetY();
$pdf->SetFont('helvetica', '', 11, '', true);
$pdf->SetXY(20, $y + 2);
$pdf->Multicell(145, 0, !empty($this->lang->line('label_sub_total')) ? $this->lang->line('label_sub_total') : 'Sub Total' . '(' . get_currency_symbol() . ')', 0, 'R', 1, 1, '', '', true, 0, false, true, 0);
$pdf->SetFont('helvetica', 'B', 11, '', true);
$pdf->SetXY(40, $y + 2);
$pdf->Multicell(155, 0, number_format((float)$sub_total, 2), 0, 'R', 1, 1, '', '', true, 0, false, true, 0);
$pdf->SetXY(40, $y + 8);
$pdf->SetFont('helvetica', '', 11, '', true);
$pdf->Multicell(125, 0, !empty($this->lang->line('label_total_tax')) ? $this->lang->line('label_total_tax') : 'Total Tax' . '(' . get_currency_symbol() . ')', 0, 'R', 1, 1, '', '', true, 0, false, true, 0);
$pdf->SetFont('helvetica', 'B', 11, '', true);
$pdf->SetXY(15, $y + 8);
$pdf->Multicell(180, 0, number_format((float)$total_tax, 2), 0, 'R', 1, 1, '', '', true, 0, false, true, 0);
$pdf->SetXY(15, $y + 14);
$pdf->SetFont('helvetica', '', 11, '', true);
$pdf->Multicell(152, 0, !empty($this->lang->line('label_final_total')) ? $this->lang->line('label_final_total') : 'Final Total' . '(' . get_currency_symbol() . ')', 0, 'R', 1, 1, '', '', true, 0, false, true, 0);
$pdf->SetFont('helvetica', 'B', 11, '', true);
$pdf->SetXY(42, $y + 14);
$pdf->Multicell(153, 0, number_format((float)$sub_total + $total_tax, 2), 0, 'R', 1, 1, '', '', true, 0, false, true, 0);



// ---------------------------------------------------------

//Close and output PDF document
$pdf->Output(get_compnay_title() . '-ESTMT-' . $estimate['id'] . '.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+