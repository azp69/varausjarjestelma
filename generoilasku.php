<?php
//============================================================+
// File name   : example_006.php
// Begin       : 2008-03-04
// Last Update : 2013-05-14
//
// Description : Example 006 for TCPDF class
//               WriteHTML and RTL support
//
// Author: Nicola Asuni
//
// (c) Copyright:
//               Nicola Asuni
//               Tecnick.com LTD
//               www.tecnick.com
//               info@tecnick.com
//============================================================+

/**
 * Creates an example PDF TEST document using TCPDF
 * @package com.tecnick.tcpdf
 * @abstract TCPDF - Example: WriteHTML and RTL support
 * @author Nicola Asuni
 * @since 2008-03-04
 */

// Include the main TCPDF library (search for installation path).



require_once('tcpdf/examples/tcpdf_include.php');

include_once("generoihtmllasku.php");

$html = "";

if (isset($_GET['laskuid']))
{
    $html = generoiHtmlLasku($_GET['laskuid']);
}
else
    die("Virhe luotaessa laskua.");

// create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Village People Oy');
$pdf->SetTitle('Lasku');
$pdf->SetSubject('Lasku');
$pdf->SetKeywords('Lasku, Village, People');

// set default header data
// $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);

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

// set some language-dependent strings (optional)
if (@file_exists(dirname(__FILE__).'/lang/swe.php')) {
	require_once(dirname(__FILE__).'/lang/swe.php');
	$pdf->setLanguageArray($l);
}

// ---------------------------------------------------------

// set font
$pdf->SetFont('dejavusans', '', 10);

// add a page
$pdf->AddPage();

// writeHTML($html, $ln=true, $fill=false, $reseth=false, $cell=false, $align='')
// writeHTMLCell($w, $h, $x, $y, $html='', $border=0, $ln=0, $fill=0, $reseth=true, $align='', $autopadding=true)

// create some HTML content

// $html = generoiHtmlLasku($laskuid, $varausid);

$pdf->writeHTML($html, true, false, true, false, '');


// MIKÄLI LÄHETETÄÄN LASKU SÄHKÖPOSTILLA
// lahetaLaskuSahkopostilla($pdf);

// MIKÄLI HALUTAAN "TALLENTAA" PDF
//$pdf->Output('lasku.pdf', 'D');

// MIKÄLI HALUTAAN TULOSTAA PDF NÄYTÖLLE

if (isset($_GET['toiminto']))
{
  $lasku = $tk->HaeLaskunTiedot($_GET['laskuid']);
        
  $varausid = $lasku->getVarausId();
        
  $varaus = $tk->HaeVaraus($varausid);
  $asiakas = $varaus->getAsiakas();

  lahetaLaskuSahkopostilla($pdf, $asiakas->getEmail());
}
else
  $pdf->Output('lasku.pdf', 'I');


function lahetaLaskuSahkopostilla($pdf, $osoite)
{
    $to = $osoite;
    //$to          = "petri.asikainen@edu.savonia.fi"; // addresses to email pdf to
    $from        = "noreply@palikka.org"; // address message is sent from
    $subject     = "Lasku Village Peoplelta"; // email subject
    $body        = "<p>Hei.<br>Kiitos kun majoituit meillä!<br><br>Viestin liitteenä on lasku, joka tulee maksaa 14pv kuluessa.<br>Tulethan toistekin!</p>"; // email body
    $pdfName     = "village_people_lasku.pdf"; // pdf file name recipient will get
    $filetype    = "application/pdf"; // type
    
    // create headers and mime boundry
    $eol = PHP_EOL;
    $semi_rand     = md5(time());
    $mime_boundary = "==Multipart_Boundary_x{$semi_rand}x";
    $headers       = "From: $from$eol" .
      "MIME-Version: 1.0$eol" .
      "Content-Type: multipart/mixed;$eol" .
      " boundary=\"$mime_boundary\"";
    
    // add html message body
      $message = "--$mime_boundary$eol" .
      "Content-Type: text/html; charset=\"iso-8859-1\"$eol" .
      "Content-Transfer-Encoding: 7bit$eol$eol" .
      $body . $eol;
    
    $attach_pdf_multipart = chunk_split( base64_encode( $pdf->Output( '', 'S' ) ) );


    // attach pdf to email
    $message .= "--$mime_boundary$eol" .
      "Content-Type: $filetype;$eol" .
      " name=\"$pdfName\"$eol" .
      "Content-Disposition: attachment;$eol" .
      " filename=\"$pdfName\"$eol" .
      "Content-Transfer-Encoding: base64$eol$eol" .
      $attach_pdf_multipart . $eol .
      "--$mime_boundary--";
    
    // Send the email
    if(mail($to, $subject, $message, $headers)) {
      echo "Lasku lähetettiin onnistuneesti.";
    }
    else {
      echo "Sähköpostin lähetys ei jostain syystä onnistu.";
    }
}