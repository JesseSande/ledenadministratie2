<?php

namespace App\Http\Controllers;

use App\Models\Family;
use App\Models\MemberYear;
use Illuminate\Http\Request;

class FamilyController extends Controller
{
    // Methode om view families index weer te geven
    public function index() 
    {
        // Haal alle families op uit de database en tel het aantal familieleden per familie
        $families = Family::withCount('familyMembers')->get();
    
        // Geef de families door aan de view
        return view('families.index', compact('families'));
    }    

    // Methode om view familie aanmaken weer te geven
    public function create() 
    {
        return view('families.create');
    }

    // Methode om nieuw aangemaakte familie op te slaan
    public function store(Request $request) 
    {
        // Normalizeer het adres: verwijder spaties en zet om naar hoofdletters
        $normalizedAddress = strtoupper(preg_replace('/\s+/', '', $request->input('address')));

        // Formatteer het adres met de juiste spaties
        $formattedAddress = preg_replace('/^(\d{4}[A-Z]{2})(\d+[A-Z]?)$/', '$1 $2', $normalizedAddress);

        // Voeg het geformatteerde adres toe aan de request data
        $data = $request->merge(['address' => $formattedAddress])->validate([
            'family_name' => 'required|string|max:255|regex:/^[a-zA-Z\s]+$/',
            'address' => [
                'required',
                'regex:/\d{4}[[:space:]]?[a-zA-Z]{2}[[:space:]]?\d+[A-Z]?/',
                function ($attribute, $value, $fail) {
                    if (Family::where('address', $value)->exists()) {
                        $fail('Er woont al een familie op dit adres.');
                    }
                }
            ],
        ], [
            'family_name.regex' => 'De ingevulde familienaam is niet geldig. Gebruik alleen letters en eventueel spaties.',
            'address.regex' => 'Het ingevulde adres is niet geldig. Vul postcode + huisnummer in, bijv.: 1234AB 40E.',
        ]);

        // Maak de nieuwe familie aan
        $newFamily = Family::create($data);

        return redirect(route('families.index'));
    }

    public function edit(Family $family)
    {
        // Geef de familie door aan de view
        return view('families.edit', compact('family'));
    }

    public function update(Request $request, Family $family)
    {
        // Normalizeer het adres: verwijder spaties en zet om naar hoofdletters
        $normalizedAddress = strtoupper(preg_replace('/\s+/', '', $request->input('address')));

        // Formatteer het adres met de juiste spaties
        $formattedAddress = preg_replace('/^(\d{4}[A-Z]{2})(\d+[A-Z]?)$/', '$1 $2', $normalizedAddress);

        // Voeg het geformatteerde adres toe aan de request data
        $data = $request->merge(['address' => $formattedAddress])->validate([
            'family_name' => 'required|string|max:255|regex:/^[a-zA-Z\s]+$/',
            'address' => [
                'required',
                'regex:/\d{4}[[:space:]]?[a-zA-Z]{2}[[:space:]]?\d+[A-Z]?/',
                function ($attribute, $value, $fail) use ($family) {
                    if (Family::where('address', $value)->where('id', '!=', $family->id)->exists()) {
                        $fail('Er woont al een familie op dit adres.');
                    }
                }
            ],
        ], [
            'family_name.regex' => 'De ingevulde familienaam is niet geldig. Gebruik alleen letters en eventueel spaties.',
            'address.regex' => 'Het ingevulde adres is niet geldig. Vul postcode + huisnummer in, bijv.: 1234AB 40E.',
        ]);

        // Update de familie met de nieuwe gegevens
        $family->update($data);

        // Redirect terug naar de familie index pagina met een succesbericht
        return redirect(route('families.index'))->with('success', 'Familie succesvol bijgewerkt.');
    }

    public function destroy($familyId)
    {
        // Haal de familie op
        $family = Family::findOrFail($familyId);

        // Haal alle familieleden van deze familie op
        $familyMembers = $family->familyMembers;

        // Verwijder alle gerelateerde contributies en familieleden
        foreach ($familyMembers as $familyMember) {
            MemberYear::where('family_member_id', $familyMember->id)->delete();
            $familyMember->delete();
        }

        // Verwijder de familie zelf
        $family->delete();

        // Redirect naar de index pagina van families met een succesbericht
        return redirect()->route('families.index')
            ->with('success', 'Familie en alle gerelateerde gegevens succesvol verwijderd.');
    }
}