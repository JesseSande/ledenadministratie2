<?php

namespace App\Http\Controllers;

use App\Models\FamilyMember;
use App\Models\FiscalYear;
use App\Models\MemberYear;
use Illuminate\Http\Request;

class MemberYearController extends Controller
{
    // Methode om de contributies van een familielid weer te geven
    public function index($familyMemberId)
    {
        // Haal het familielid op
        $familyMember = FamilyMember::findOrFail($familyMemberId);

        // Haal alle geregistreerde contributiejaren op voor dit familielid (met eager loading)
        $contributions = $familyMember->memberYears()->with('membershipType', 'contribution')->get();

        // Geef de gegevens door aan de view
        return view('member_years.index', compact('familyMember', 'contributions'));
    }

    public function create($familyMemberId)
    {
        // Haal alle beschikbare boekjaren op
        $fiscalYears = FiscalYear::all();

        // Haal het familielid op op basis van het ID
        $familyMember = FamilyMember::findOrFail($familyMemberId);

        // Geef de benodigde data door aan de view
        return view('member_years.create', compact('fiscalYears', 'familyMember'));
    }

    public function store(Request $request, $familyMemberId)
    {
        // Valideer de invoer
        $data = $request->validate([
            'fiscal_year_id' => [
                'required',
                'exists:fiscal_years,id',
                function ($attribute, $value, $fail) use ($familyMemberId) {
                    // Controleer of er al een contributie is geregistreerd voor dit familielid in dit boekjaar
                    if (MemberYear::where('family_member_id', $familyMemberId)
                        ->where('fiscal_year_id', $value)
                        ->exists()) {
                        $fail('Voor dit boekjaar is al een contributie geregistreerd voor dit lid.');
                    }
    
                    // Controleer of er een basisbedrag is ingesteld voor het geselecteerde boekjaar
                    if (!\App\Models\Contribution::where('fiscal_year_id', $value)->exists()) {
                        $fail('Er is nog geen basisbedrag ingesteld voor dit boekjaar. Contributie kan nog niet worden geregistreerd.');
                    }
    
                    // Controleer of er lidmaatschappen zijn ingesteld voor het geselecteerde boekjaar
                    if (!\App\Models\MembershipType::where('fiscal_year_id', $value)->exists()) {
                        $fail('Er zijn nog geen lidmaatschappen ingesteld voor dit boekjaar. Contributie kan nog niet worden geregistreerd.');
                    }
                },
            ],
        ]);
    
        // Haal de benodigde data op
        $familyMember = FamilyMember::findOrFail($familyMemberId);
        $fiscalYear = FiscalYear::findOrFail($data['fiscal_year_id']);
    
        // Sla het nieuwe MemberYear-record op
        $memberYear = MemberYear::create([
            'family_member_id' => $familyMember->id,
            'fiscal_year_id' => $fiscalYear->id,
        ]);
    
        // Bereken de contributie via het model MemberYear
        $calculatedContribution = $memberYear->calculateContribution();
    
        // Redirect naar de index pagina met een succesbericht
        return redirect()->route('member_years.index', ['family_member' => $familyMemberId])
            ->with('success', 'Contributie succesvol berekend en geregistreerd.');
    }
    
    public function destroy(MemberYear $memberYear)
    {
        // Verwijder het MemberYear record
        $memberYear->delete();

        // Redirect naar de index pagina met een succesbericht
        return redirect()->route('member_years.index', $memberYear->family_member_id)
            ->with('success', 'Berekende contributie succesvol verwijderd.');
    }
}