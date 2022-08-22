<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PDF;

class PdfController extends UtilController
{

    public function index()
    {

        $pdf = PDF::loadView('auth.teste', []);

        return $pdf->download('auth.pdf');
    }

}
