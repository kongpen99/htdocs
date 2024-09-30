<?php
require("../fpdf/fpdf.php");

//customer and invoice details
$info = [
    "customer" => "Ram Kumar",
    "address" => "4th cross,Car Street,",
    "city" => "Salem 636204.",
    "invoice_no" => "1000001",
    "invoice_date" => "30-11-2021",
    "total_amt" => "5200.00",
    "words" => "Rupees Five Thousand Two Hundred Only",
];


//invoice Products
$products_info = [
    [
        "name" => "Keyboard",
        "price" => "500.00",
        "qty" => 2,
        "total" => "1000.00"
    ],
    [
        "name" => "Mouse",
        "price" => "400.00",
        "qty" => 3,
        "total" => "1200.00"
    ],
    [
        "name" => "UPS",
        "price" => "3000.00",
        "qty" => 1,
        "total" => "3000.00"
    ],
];

class PDF extends FPDF
{
    // function Header()
    // {

    //     // //Display Company Info
    //     // $this->SetFont('Arial', 'B', 14);
    //     // $this->Cell(50, 10, "ABC COMPUTERS", 0, 1);
    //     // $this->SetFont('Arial', '', 14);
    //     // $this->Cell(50, 7, "West Street,", 0, 1);
    //     // $this->Cell(50, 7, "Salem 636002.", 0, 1);
    //     // $this->Cell(50, 7, "PH : 8778731770", 0, 1);

    //     // //Display INVOICE text
    //     // $this->SetY(15);
    //     // $this->SetX(-40);
    //     // $this->SetFont('Arial', 'B', 18);
    //     // $this->Cell(50, 10, "INVOICE", 0, 1);

    //     // //Display Horizontal line
    //     // $this->Line(0, 48, 210, 48);
    // }

    function body($info, $products_info)
    {

        //Billing Details
        $this->SetY(10);
        $this->SetX(10);
        $this->SetFont('Arial', 'B', 12);
        $this->Cell(50, 10, "Bill To: ", 0, 1);
        $this->SetFont('Arial', '', 12);
        $this->Cell(50, 7, $info["customer"], 0, 1);
        $this->Cell(50, 7, $info["address"], 0, 1);
        $this->Cell(50, 7, $info["city"], 0, 1);

        //Display Invoice no
        $this->SetY(10);
        $this->SetX(-60);
        $this->Cell(50, 7, "Invoice No : " . $info["invoice_no"]);

        //Display Invoice date
        $this->SetY(20);
        $this->SetX(-60);
        $this->Cell(50, 7, "Invoice Date : " . $info["invoice_date"]);

        //Display Table headings
        $this->SetY(60);
        $this->SetX(20);
        $this->SetFont('Arial', 'B', 12);
        $this->Cell(40, 9, "CUSTOMER", 1, 0 ,"C");
        $this->Cell(20, 9, "LINE", 1, 0, "C");      
        $this->Cell(30, 9, "NG POSITION", 1, 0, "C");
        $this->Cell(40, 9, "NG CASE", 1, 0, "C");
        $this->Cell(30, 9, "NG PROCESS", 1, 0, "C");
        $this->Cell(15, 9, "QTY", 1, 1, "C");
        $this->SetFont('Arial', '', 12);

        //Display table product rows
        foreach ($products_info as $row) {
            $this->SetX(20);
            $this->Cell(40, 9, $row["name"], "LR", 0);
            $this->Cell(20, 9, $row["price"], "R", 0, "C");
            $this->Cell(30, 9, $row["total"], "R", 0, "C");
            $this->Cell(40, 9, $row["total"], "R", 0, "C");
            $this->Cell(30, 9, $row["total"], "R", 0, "C");
            $this->Cell(15, 9, $row["qty"], "R", 1, "C");
        }
        //Display table empty rows
        for ($i = 0; $i < 12 - count($products_info); $i++) {
            $this->SetX(20);
            $this->Cell(40, 9, "", "LR", 0);
            $this->Cell(20, 9, "", "R", 0, "R");            
            $this->Cell(30, 9, "", "R", 0, "R");
            $this->Cell(40, 9, "", "R", 0, "R");
            $this->Cell(30, 9, "", "R", 0, "R");
            $this->Cell(15, 9, "", "R", 1, "C");
        }
        //Display table total row
        // $this->SetFont('Arial', 'B', 12);
        $this->SetX(20);
        $this->Cell(175, 0, "", 1, "B");
       

        //Display amount in words
        
    }
    function Footer()
    {

        
    }
}
//Create A4 Page with Portrait 
$pdf = new PDF("P", "mm", "A4");
$pdf->AddPage();
$pdf->body($info, $products_info);
$pdf->Output();
