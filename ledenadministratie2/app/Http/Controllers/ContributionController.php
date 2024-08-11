<?php

namespace App\Http\Controllers;

use App\Models\FiscalYear;
use App\Models\Contribution;
use Illuminate\Http\Request;

class ContributionController extends Controller
{
    // Methode om alle contributie basisbedragen over de jaren heen weer te geven
    public function index() 
    {
        // Haal alle contributies op, met bijbehorende boekjaren
        $contributions = Contribution::with('fiscalYear')->get();

        // Geef de contributies door aan de view
        return view('contributions.index', compact('contributions'));
    }

    // Methode om het formulier weer te geven voor het instellen van een nieuw basisbedrag
    public function create()
    {
        // Haal alle fiscale jaren op om in een dropdown te tonen
        $fiscalYears = FiscalYear::all();
        return view('contributions.create', compact('fiscalYears'));
    }

    // Methode om het nieuwe basisbedrag op te slaan
    public function store(Request $request)
    {
        // Validatie van het formulier inclusief de controle of het boekjaar al een basisbedrag heeft. Code m.b.v. ChatGPT4o Laravel GPT. 
        $data = $request->validate([
            'fiscal_year_id' => [
                'required',
                'exists:fiscal_years,id',
                function ($attribute, $value, $fail) {
                    if (Contribution::where('fiscal_year_id', $value)->exists()) {
                        $fail('Voor dit boekjaar is al een basisbedrag ingesteld.');
                    }
                },
            ],
            'amount' => 'required|numeric|min:0|max:1000',
        ]);

        // Basisbedrag aanmaken in de database
        Contribution::create($data);

        // Redirect naar de index pagina met een succesbericht
        return redirect()->route('contributions.index')->with('success', 'Basisbedrag succesvol toegevoegd.');
    }

    public function edit(Contribution $contribution)
    {
        // Geef het basisbedrag door aan de view
        return view('contributions.edit', compact('contribution'));
    }    
    
    public function update(Request $request, Contribution $contribution)
    {
        // Validatie van het basisbedrag
        $data = $request->validate([
            'amount' => 'required|numeric|min:0|max:1000',
        ]);
    
        // Update het basisbedrag in de database
        $contribution->update($data);
    
        // Redirect naar de index pagina met een succesbericht
        return redirect()->route('contributions.index')->with('success', 'Basisbedrag succesvol bijgewerkt.');
    }       
}