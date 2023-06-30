<?php

namespace App\Http\Controllers;

use App\Models\Clas;
use App\Models\Student;
use App\Models\Subject;
use App\Models\Term;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class PDFController extends Controller
{
    //

    public function pdf()
    {
        $pdf = PDF::loadView('welcome');
        return $pdf->download('welcome.pdf');
    }

    public function report()
    {
        return view('reports.report');
    }

    public function scoresheet(Clas $clas, Subject $subject)
    {
        return view('pdf.sheet', compact(['clas', 'subject']));
    }

    public function reportCard(Term $term = null, Student $student = null)
    {
        // $term = Term::find($id) ?? latestTerm();
        return view('pdf.report-card', compact(['term', 'student']));
    }
}