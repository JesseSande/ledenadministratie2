<?php

namespace App\Http\Controllers;

use App\Models\FiscalYear;
use Illuminate\Http\Request;

class FiscalYearController extends Controller
{
    // Methode om view fiscal_years index weer te geven
    public function index() 
    {
        // Haal alle boekjaren op uit de database met de relatie memberYears
        $fiscalYears = FiscalYear::with('memberYears')->get();

        // Voor elk boekjaar de totale contributies en het aantal geregistreerde contributies berekenen
        foreach ($fiscalYears as $year) {
            $year->total_contributions = $year->memberYears->sum(function ($memberYear) {
                return $memberYear->calculateContribution();
            });

            // Bereken het aantal geregistreerde contributies voor dit boekjaar
            $year->contributions_count = $year->memberYears->count();
        }

        // Geef de opgehaalde boekjaren door aan de view
        return view('fiscal_years.index', compact('fiscalYears'));
    }

    // Methode om view boekjaar aanmaken weer te geven
    public function create() 
    {
        return view('fiscal_years.create');
    }

    // Methode om nieuw aangemaakte boekjaar op te slaan
    public function store(Request $request) 
    {
        // Validatie van het formulier inclusief de controle of het jaar al bestaat
        $data = $request->validate([
            'year' => [
                'required',
                'integer',
                'min:1900',
                'max:' . (date('Y') + 5),
                function ($attribute, $value, $fail) {
                    if (FiscalYear::where('year', $value)->exists()) {
                        $fail('Dit jaar is al geregistreerd als boekjaar.');
                    }
                },
            ],
        ]);

        // Boekjaar aanmaken in de database
        $newFiscalYear = FiscalYear::create($data);

        // Redirect naar de index pagina met een succesbericht
        return redirect()->route('fiscal_years.index', ['fiscal_year_id' => $newFiscalYear->id])
                     ->with('success', 'Boekjaar succesvol toegevoegd.');
    }
}