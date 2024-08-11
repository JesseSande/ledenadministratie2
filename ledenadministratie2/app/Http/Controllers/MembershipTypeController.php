<?php

namespace App\Http\Controllers;

use App\Models\MembershipType;
use App\Models\FiscalYear;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class MembershipTypeController extends Controller
{
    // Methode om de lidmaatschappen van het gekozen boekjaar weer te geven
    public function index(Request $request)
    {
        // Haal het geselecteerde boekjaar op uit de query parameters, gebruik null als default
        $selectedYearId = $request->query('fiscal_year_id', null);

        // Haal alle beschikbare boekjaren op voor de dropdown
        $fiscalYears = FiscalYear::all();

        // Als er een boekjaar is geselecteerd, haal dan de lidmaatschappen op voor dat jaar
        if ($selectedYearId) {
            $membershipTypes = MembershipType::where('fiscal_year_id', $selectedYearId)->get();
        } else {
            $membershipTypes = collect(); // Lege collectie als er geen boekjaar is geselecteerd
        }

        return view('membership_types.index', compact('fiscalYears', 'membershipTypes', 'selectedYearId'));
    }

    // Stap 1: Laat de gebruiker een boekjaar kiezen
    public function createStep1()
    {
        $fiscalYears = FiscalYear::all();
        return view('membership_types.create_step1', compact('fiscalYears'));
    }

    // Stap 2: Controleer of er al lidmaatschappen zijn voor het gekozen boekjaar
    public function createStep2(Request $request)
    {
        $request->validate([
            'fiscal_year_id' => 'required|exists:fiscal_years,id',
        ]);

        $fiscalYearId = $request->input('fiscal_year_id');

        // Controleer of er al lidmaatschappen voor dit boekjaar bestaan
        if (MembershipType::where('fiscal_year_id', $fiscalYearId)->exists()) {
            return redirect()->back()->withErrors([
                'fiscal_year_id' => 'Er zijn al lidmaatschappen geregistreerd op dit boekjaar. Kies een ander boekjaar of ga terug naar het lidmaatschap overzicht om de lidmaatschappen van het huidige boekjaar te bewerken.'
            ]);
        }

        // Als er nog geen lidmaatschappen zijn, ga naar het volgende scherm
        $fiscalYear = FiscalYear::find($fiscalYearId);
        return view('membership_types.create_step2', compact('fiscalYear'));
    }

    public function store(Request $request)
    {
        // Maak een validator instance
        $validator = Validator::make($request->all(), [
            'fiscal_year_id' => 'required|exists:fiscal_years,id',
            'age_min.*' => 'required|integer|min:0|max:125',
            'age_max.*' => 'required|integer|min:0|max:125',
            'discount.*' => 'required|integer|min:0|max:100',
        ], [
            'age_min.*.required' => 'Het minimale leeftijdsveld is verplicht voor alle lidmaatschappen.',
            'age_max.*.required' => 'Het maximale leeftijdsveld is verplicht voor alle lidmaatschappen.',
            'discount.*.required' => 'Het kortingsveld is verplicht voor alle lidmaatschappen.',
            'discount.*.min' => 'Het kortingspercentage moet minimaal 0% zijn.',
            'discount.*.max' => 'Het kortingspercentage mag maximaal 100% zijn.',
        ]);

        // Controleer of de validatie mislukt
        if ($validator->fails()) {
            return view('membership_types.create_step2', [
                'fiscalYear' => FiscalYear::find($request->input('fiscal_year_id')),
                'errors' => $validator->errors()->all(), // Geef alle fouten door
            ]);
        }

        // Leeg array om foutmeldingen op te slaan
        $errors = [];

        // Validatie: Zorg ervoor dat de leeftijden niet overlappen en dat alle leeftijden van 0-125 zijn afgedekt
        $previousMaxAge = -1;
        $coveredAges = [];

        foreach (['jeugd', 'aspirant', 'junior', 'senior', 'oudere'] as $title) {
            $minAge = $request->input('age_min')[$title];
            $maxAge = $request->input('age_max')[$title];

            if ($minAge <= $previousMaxAge) {
                $errors[] = "Leeftijden voor $title overlappen met een eerder lidmaatschap. Zorg ervoor dat er geen overlap is.";
            }

            if ($minAge > $maxAge) {
                $errors[] = "De minimale leeftijd voor $title moet kleiner of gelijk zijn aan de maximale leeftijd.";
            }

            $coveredAges = array_merge($coveredAges, range($minAge, $maxAge));
            $previousMaxAge = $maxAge;
        }

        // Controleer of het volledige bereik van 0 tot 125 is afgedekt
        $fullRange = range(0, 125);
        $missingAges = array_diff($fullRange, $coveredAges);

        if (!empty($missingAges)) {
            $errors[] = "Er ontbreken leeftijden in de lidmaatschapsbereiken. Zorg ervoor dat alle leeftijden van 0 tot 125 zijn afgedekt.";
        }

        // Als er aanvullende fouten zijn, retourneer de view met de foutmeldingen
        if (!empty($errors)) {
            return view('membership_types.create_step2', [
                'fiscalYear' => FiscalYear::find($request->input('fiscal_year_id')),
                'errors' => array_merge($errors, $validator->errors()->all()), // Voeg validatie fouten toe aan de array
            ]);
        }

        // Sla de lidmaatschappen op als er geen fouten zijn
        foreach (['jeugd', 'aspirant', 'junior', 'senior', 'oudere'] as $title) {
            MembershipType::create([
                'fiscal_year_id' => $request->input('fiscal_year_id'),
                'title' => $title,
                'age_min' => $request->input('age_min')[$title],
                'age_max' => $request->input('age_max')[$title],
                'discount' => $request->input('discount')[$title],
            ]);
        }

        // Redirect naar de index pagina met een succesbericht
        return redirect()->route('membership_types.index')->with('success', 'Lidmaatschappen succesvol toegevoegd.');
    }

    public function edit($fiscalYearId)
    {
        // Haal het boekjaar op
        $fiscalYear = FiscalYear::findOrFail($fiscalYearId);

        // Haal de lidmaatschappen op voor dit boekjaar
        $membershipTypes = MembershipType::where('fiscal_year_id', $fiscalYearId)->get()->keyBy('title');

        // Geef de data door aan de view
        return view('membership_types.edit', compact('fiscalYear', 'membershipTypes'));
    }

    public function update(Request $request, $fiscalYearId)
    {
        $validator = Validator::make($request->all(), [
            'fiscal_year_id' => 'required|exists:fiscal_years,id',
            'age_min.*' => 'required|integer|min:0|max:125',
            'age_max.*' => 'required|integer|min:0|max:125',
            'discount.*' => 'required|integer|min:0|max:100',
        ], [
            'age_min.*.required' => 'Het minimale leeftijdsveld is verplicht voor alle lidmaatschappen.',
            'age_max.*.required' => 'Het maximale leeftijdsveld is verplicht voor alle lidmaatschappen.',
            'discount.*.required' => 'Het kortingsveld is verplicht voor alle lidmaatschappen.',
            'discount.*.min' => 'Het kortingspercentage moet minimaal 0% zijn.',
            'discount.*.max' => 'Het kortingspercentage mag maximaal 100% zijn.',
        ]);
    
        // Controleer of de validatie mislukt
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
    
        $errors = [];
        $previousMaxAge = -1;
        $coveredAges = [];
    
        foreach (['jeugd', 'aspirant', 'junior', 'senior', 'oudere'] as $title) {
            $minAge = $request->input('age_min')[$title];
            $maxAge = $request->input('age_max')[$title];
    
            if ($minAge <= $previousMaxAge) {
                $errors[] = "Leeftijden voor $title overlappen met een eerder lidmaatschap. Zorg ervoor dat er geen overlap is.";
            }
    
            if ($minAge > $maxAge) {
                $errors[] = "De minimale leeftijd voor $title moet kleiner of gelijk zijn aan de maximale leeftijd.";
            }
    
            $coveredAges = array_merge($coveredAges, range($minAge, $maxAge));
            $previousMaxAge = $maxAge;
        }
    
        $fullRange = range(0, 125);
        $missingAges = array_diff($fullRange, $coveredAges);
    
        if (!empty($missingAges)) {
            $errors[] = "Er ontbreken leeftijden in de lidmaatschapsbereiken. Zorg ervoor dat alle leeftijden van 0 tot 125 zijn afgedekt.";
        }
    
        // Als er aanvullende fouten zijn, retourneer de view met de foutmeldingen
        if (!empty($errors)) {
            return redirect()->back()
                ->withErrors($errors)
                ->withInput();
        }        
    
        foreach (['jeugd', 'aspirant', 'junior', 'senior', 'oudere'] as $title) {
            $membershipType = MembershipType::where('fiscal_year_id', $fiscalYearId)
                ->where('title', $title)
                ->first();
    
            if ($membershipType) {
                $membershipType->update([
                    'age_min' => $request->input('age_min')[$title],
                    'age_max' => $request->input('age_max')[$title],
                    'discount' => $request->input('discount')[$title],
                ]);
            }
        }
    
        return redirect()->route('membership_types.index')
            ->with('success', 'Lidmaatschappen succesvol bijgewerkt.');
    }       
}