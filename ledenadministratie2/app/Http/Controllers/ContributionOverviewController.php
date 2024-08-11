<?php

namespace App\Http\Controllers;

use App\Models\MemberYear;
use App\Models\Family;
use App\Models\FiscalYear;
use Illuminate\Http\Request;

class ContributionOverviewController extends Controller
{
    // Code m.b.v. ChatGPT4o Laravel GPT. 
    public function index(Request $request)
    {
        // Haal de filters op
        $selectedYear = $request->input('year');
        $selectedFamily = $request->input('family_id');

        // Haal de familie- en boekjaargegevens op voor de dropdowns
        $fiscalYears = FiscalYear::all();
        $families = Family::all();

        // Query voor het ophalen van contributies
        $query = MemberYear::query();

        // Pas filters toe indien nodig
        if ($selectedYear) {
            $query->forFiscalYear($selectedYear);
        }

        if ($selectedFamily) {
            $query->forFamily($selectedFamily);
        }

        // Haal de contributies op, gegroepeerd per familie en boekjaar
        $contributions = $query->with(['fiscalYear', 'familyMember.family'])
            ->get()
            ->groupBy(function ($item) {
                return $item->familyMember->family_id . ' - ' . $item->familyMember->family->family_name . ' - ' . $item->fiscalYear->year;
            });

        return view('contribution_overviews.index', compact('contributions', 'fiscalYears', 'families', 'selectedYear', 'selectedFamily'));
    }
}