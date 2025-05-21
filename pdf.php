<?php
if (isset($_POST['btn'])) {
    // Retrieve values from POST.
    $applicationnumber = $_POST['applicationnumber'] ?? '';
    $candidate        = $_POST['candidate'] ?? '';
    $father           = $_POST['father'] ?? '';
    $hname            = $_POST['hname'] ?? '';
    $num              = $_POST['num'] ?? '';
    $image            = $_POST['image'] ?? '';
    $address          = $_POST['address'] ?? '';
    $re               = $_POST['re'] ?? '';
    $addnum           = $_POST['addnum'] ?? '';
    $declaration      = $_POST['declaration'] ?? '';

    // Include the FPDF library.
    require("fpdf/fpdf.php");

    // Create a new PDF.
    $pdf = new FPDF();
    $pdf->AddPage();
    $pdf->SetFont("Calibri", "", 16);

    // Display the application data.
    $pdf->Image('p1.jpg', 10, 120, 190);

    $pdf->Cell(0, 10, "Application Number: " . $applicationnumber, 0, 1, "C");
    $pdf->Cell(0, 10, "Candidate Name: " . $candidate, 0, 1, "C");
    $pdf->Cell(0, 10, "Father/Guardian Name: " . $father, 0, 1, "C");
    $pdf->Cell(0, 10, "House Name: " . $hname, 0, 1, "C");
    $pdf->Cell(0, 10, "Phone Number: " . $num, 0, 1, "C");
    $pdf->Cell(0, 10, "Address: " . $address, 0, 1, "C");
    $pdf->Cell(0, 10, "Madrasa Name: " . $re, 0, 1, "C");
    $pdf->Cell(0, 10, "Admission Number: " . $addnum, 0, 1, "C");
    $pdf->Cell(0, 10, "Declaration: " . $declaration, 0, 1, "C");

    // Example of adding images.
    // Here p1.jpg and p2.jpg are added with 190 as the width.
        $pdf->Image('p2.jpg', 10, 180, 190);

    // Output the PDF to browser for download.
    $pdf->Output();
}
?>