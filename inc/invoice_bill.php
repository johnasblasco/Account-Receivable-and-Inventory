<?php
session_start();
require_once '../fpdf/fpdf.php';

if (isset($_GET["order_date"], $_GET["invoice_no"])) {
    $pdf = new FPDF();
    $pdf->AddPage();
    $pdf->SetFont("Arial", "B", 16);
    $pdf->Cell(190, 10, "Inventory Management System", 0, 1, "C");
    $pdf->SetFont("Arial", null, 12);

    // General Information
    $pdf->Cell(50, 10, "Date", 0, 0);
    $pdf->Cell(50, 10, ": " . $_GET["order_date"], 0, 1);
    $pdf->Cell(50, 10, "Customer Name", 0, 0);
    $pdf->Cell(50, 10, ": " . $_GET["cust_name"], 0, 1);
    $pdf->Cell(50, 10, "", 0, 1);

    // Table Headers
    $pdf->Cell(10, 10, "#", 1, 0, "C");
    $pdf->Cell(70, 10, "Product Name", 1, 0, "C");
    $pdf->Cell(30, 10, "Quantity", 1, 0, "C");
    $pdf->Cell(40, 10, "Price", 1, 0, "C");
    $pdf->Cell(40, 10, "Total (Rs)", 1, 1, "C");

    // Loop through products
    for ($i = 0; $i < count($_GET["pid"]); $i++) {
        $pdf->Cell(10, 10, ($i + 1), 1, 0, "C");
        $pdf->Cell(70, 10, $_GET["pro_name"][$i], 1, 0, "C");
        $pdf->Cell(30, 10, $_GET["qty"][$i], 1, 0, "C");
        $pdf->Cell(40, 10, $_GET["price"][$i], 1, 0, "C");
        $pdf->Cell(40, 10, ($_GET["qty"][$i] * $_GET["price"][$i]), 1, 1, "C");
    }

    // Totals
    $pdf->Cell(50, 10, "", 0, 1);
    $pdf->Cell(50, 10, "Sub Total", 0, 0);
    $pdf->Cell(50, 10, ": " . $_GET["sub_total"], 0, 1);
    $pdf->Cell(50, 10, "GST Tax", 0, 0);
    $pdf->Cell(50, 10, ": " . $_GET["gst"], 0, 1);
    $pdf->Cell(50, 10, "Discount", 0, 0);
    $pdf->Cell(50, 10, ": " . $_GET["discount"], 0, 1);
    $pdf->Cell(50, 10, "Net Total", 0, 0);
    $pdf->Cell(50, 10, ": " . $_GET["net_total"], 0, 1);
    $pdf->Cell(50, 10, "Paid", 0, 0);
    $pdf->Cell(50, 10, ": " . $_GET["paid"], 0, 1);
    $pdf->Cell(50, 10, "Due Amount", 0, 0);
    $pdf->Cell(50, 10, ": " . $_GET["due"], 0, 1);
    $pdf->Cell(50, 10, "Payment Type", 0, 0);
    $pdf->Cell(50, 10, ": " . $_GET["payment_type"], 0, 1);

    // Signature
    $pdf->Cell(180, 10, "Signature", 0, 0, "R");

    // Output PDF to browser and save it
    $pdf->Output();
    // Or, save to file:
    // $pdf->Output("../PDF_INVOICE/PDF_INVOICE_" . $_GET["invoice_no"] . ".pdf", "F");
}
?>