<?php
require('fpdf.php');

// Retrieve submitted data from POST.
$appNumber         = isset($_POST['applicationnumber']) ? $_POST['applicationnumber'] : '';
$candidateDisplay  = isset($_POST['candidate']) ? $_POST['candidate'] : '';
$fatherDisplay     = isset($_POST['father']) ? $_POST['father'] : '';
$hnameDisplay      = isset($_POST['hname']) ? $_POST['hname'] : '';
$numDisplay        = isset($_POST['num']) ? $_POST['num'] : '';
$imageData         = isset($_POST['image']) ? $_POST['image'] : ''; // Could be a URL or base64 encoded string.
$addressDisplay    = isset($_POST['address']) ? $_POST['address'] : '';
$madrasaDisplay    = isset($_POST['re']) ? $_POST['re'] : '';
$addnumDisplay     = isset($_POST['addnum']) ? $_POST['addnum'] : '';
$declarationDisplay= isset($_POST['declaration']) ? $_POST['declaration'] : '';

// Create a new PDF document (A4, portrait, with measurements in centimeters)
$pdf = new FPDF('P','cm','A4');
$pdf->SetMargins(1,1,1);
$pdf->AddPage();

// === Top Image ===
// Placed at Y=1cm and spanning the full width (19cm). Adjust the height as needed.
$pdf->Image('p1.jpg', 1, 1, 19);
$pdf->Ln(3); // Adjust vertical space; depends on p1.jpg height.

// === Set font and default style ===
$pdf->SetFont('Arial','',20);  // Use AddFont() if you need Calibri.
$pdf->SetTextColor(0,0,0);

// === Define column widths and the default row height ===
$col1 = 4; // For labels
$col2 = 1; // For the colon (":")
$col3 = 7; // For the data (e.g. application number)
$col4 = 4; // For the image cell which is manually designed to span several rows
$col5 = 3; // For any extra information (or left blank)
$rowHeight = 1; // Height of a standard text cell

// === Row: Application Number (with a cell for the candidate's photo spanning 4 rows) ===
$startY = $pdf->GetY();
$pdf->Cell($col1, $rowHeight, "Application Number", 1, 0, 'L');
$pdf->Cell($col2, $rowHeight, ":", 1, 0, 'L');

// Set blue text color for the application number
$pdf->SetTextColor(0, 0, 255);
$pdf->Cell($col3, $rowHeight, $appNumber, 1, 0, 'L');
$pdf->SetTextColor(0, 0, 0);

// Here we designate an image cell that spans 4 rows.
$spanHeight = $rowHeight * 4;
$cellX = $pdf->GetX();
$cellY = $pdf->GetY();
$pdf->Cell($col4, $spanHeight, "", 1, 0, 'C');

// Place the candidate's photo inside the image cell (with a small padding).
if (!empty($imageData)) {
    // Check if the image data is base64 encoded (starts with 'data:image')
    if (strpos($imageData, 'data:image') === 0) {
        $parts = explode(',', $imageData);
        $imgDecoded = base64_decode($parts[1]);
        $tempFile = tempnam(sys_get_temp_dir(), 'img_') . '.png';
        file_put_contents($tempFile, $imgDecoded);
        $pdf->Image($tempFile, $cellX + 0.2, $cellY + 0.2, $col4 - 0.4, $spanHeight - 0.4);
        // Optionally, delete $tempFile after usage.
    } else {
        // If the value is a file path or URL:
        $pdf->Image($imageData, $cellX + 0.2, $cellY + 0.2, $col4 - 0.4, $spanHeight - 0.4);
    }
} else {
    // If no image data is provided, use a default image.
    $pdf->Image('f1.jpg', $cellX + 0.2, $cellY + 0.2, $col4 - 0.4, $spanHeight - 0.4);
}

// The 5th column in this row is left empty.
$pdf->Cell($col5, $rowHeight, "", 1, 1, 'L');

// === Row: Candidate Name ===
$pdf->Cell($col1, $rowHeight, "Name of Candidate*", 1, 0, 'L');
$pdf->Cell($col2, $rowHeight, ":", 1, 0, 'L');
// Merge the remaining columns (col3 + col5)
$pdf->Cell($col3 + $col5, $rowHeight, $candidateDisplay, 1, 1, 'L');

// === Row: Name of Father/Guardian ===
$pdf->Cell($col1, $rowHeight, "Name of Father/Guardian*", 1, 0, 'L');
$pdf->Cell($col2, $rowHeight, ":", 1, 0, 'L');
$pdf->Cell($col3 + $col5, $rowHeight, $fatherDisplay, 1, 1, 'L');

// === Row: House Name ===
$pdf->Cell($col1, $rowHeight, "House Name*", 1, 0, 'L');
$pdf->Cell($col2, $rowHeight, ":", 1, 0, 'L');
$pdf->Cell($col3 + $col5, $rowHeight, $hnameDisplay, 1, 1, 'L');

// === Row: Phone Number ===
$pdf->Cell($col1, $rowHeight, "Phone Number*", 1, 0, 'L');
$pdf->Cell($col2, $rowHeight, ":", 1, 0, 'L');
// Merge columns to span the remaining width across the table.
$pdf->Cell($col3 + $col4 + $col5, $rowHeight, $numDisplay, 1, 1, 'L');

// === Row: Mahall Registration No & Address ===
$pdf->Cell($col1, $rowHeight, "Mahall Registration No & Address*", 1, 0, 'L');
$pdf->Cell($col2, $rowHeight, ":", 1, 0, 'L');
$pdf->Cell($col3 + $col4 + $col5, $rowHeight, $addressDisplay, 1, 1, 'L');

// === Row: Name of Madrasa ===
$pdf->Cell($col1, $rowHeight, "Name of Madrasa*", 1, 0, 'L');
$pdf->Cell($col2, $rowHeight, ":", 1, 0, 'L');
$pdf->Cell($col3 + $col4 + $col5, $rowHeight, $madrasaDisplay, 1, 1, 'L');

// === Row: Admission Number ===
$pdf->Cell($col1, $rowHeight, "Admission Number*", 1, 0, 'L');
$pdf->Cell($col2, $rowHeight, ":", 1, 0, 'L');
$pdf->Cell($col3 + $col4 + $col5, $rowHeight, $addnumDisplay, 1, 1, 'L');

// === Row: Declaration (if needed) ===
$pdf->Cell($col1, $rowHeight, "Declaration", 1, 0, 'L');
$pdf->Cell($col2, $rowHeight, ":", 1, 0, 'L');
$pdf->Cell($col3 + $col4 + $col5, $rowHeight, $declarationDisplay, 1, 1, 'L');

// === Bottom Image ===
$pdf->Ln(0.5);
$bottomImageHeight = 3;
$pdf->Cell(19, $bottomImageHeight, "", 1, 1, 'C');
$xBottom = $pdf->GetX();
$yBottom = $pdf->GetY() - $bottomImageHeight;
$pdf->Image('p2.jpg', $xBottom + 0.2, $yBottom + 0.2, 19 - 0.4, $bottomImageHeight - 0.4);

// Output the generated PDF to the browser.
$pdf->Output();
?>
