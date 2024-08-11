<?php

namespace App\Http\Controllers;

use App\Models\Family;
use App\Models\FamilyMember;
use App\Models\MemberRole;
use App\Models\MemberYear;
use Illuminate\Http\Request;

class FamilyMemberController extends Controller
{
    public function index($familyId)
    {
        // Haal de familie op op basis van het id
        $family = Family::findOrFail($familyId);

        // Haal alle familieleden op die bij deze familie horen
        $familyMembers = $family->familyMembers; 

        // Geef de familieleden door aan de view
        return view('family_members.index', compact('familyMembers', 'family'));
    }

    public function create($familyId)
    {
        // Haal de familie op op basis van het id
        $family = Family::findOrFail($familyId);

        // Haal alle rollen op
        $memberRoles = MemberRole::all(); 

        // Geef door aan de view
        return view('family_members.create', compact('family', 'memberRoles'));
    }

    public function store(Request $request, $familyId)
    {
        // Invoervalidatie
        $data = $request->validate([
            'first_name' => [
                'required',
                'string',
                'max:255',
                'regex:/^[a-zA-Z\s]+$/'
            ],
            'birth_date' => 'required|date|before:today',
            'family_role' => 'required|string',
            'member_role_id' => 'required|exists:member_roles,id',
        ], [
            'first_name.regex' => 'De ingevulde voornaam is niet geldig. Gebruik alleen letters en eventueel spaties.',
            'birth_date.before' => 'De ingevulde geboortedatum is niet geldig. Kies een datum (dd-mm-jjjj) uit het verleden.',
            'family_role.required' => 'Kies een familierol.',
            'member_role_id.required' => 'Kies een lidmaatschapsrol.',
        ]);

        // Voeg het family_id toe
        $data['family_id'] = $familyId; 

        // Maak het nieuwe familielid aan
        FamilyMember::create($data);

        return redirect()->route('family_members.index', $familyId)->with('success', 'Familielid succesvol toegevoegd.');
    }

    public function edit($familyId, $familyMemberId)
    {
        // Haal de familie en het familielid op
        $family = Family::findOrFail($familyId);
        $familyMember = FamilyMember::findOrFail($familyMemberId);

        // Haal alle lidmaatschapsrollen op
        $memberRoles = MemberRole::all(); 

        // Geef de gegevens door aan de edit view
        return view('family_members.edit', compact('family', 'familyMember', 'memberRoles'));
    }

    public function update(Request $request, $familyId, $familyMemberId)
    {
        // Invoervalidatie
        $data = $request->validate([
            'first_name' => [
                'required',
                'string',
                'max:255',
                'regex:/^[a-zA-Z\s]+$/'
            ],
            'birth_date' => 'required|date|before:today',
            'family_role' => 'required|string',
            'member_role_id' => 'required|exists:member_roles,id',
        ], [
            'first_name.regex' => 'De ingevulde voornaam is niet geldig. Gebruik alleen letters en eventueel spaties.',
            'birth_date.before' => 'De ingevulde geboortedatum is niet geldig. Kies een datum (dd-mm-jjjj) uit het verleden.',
            'family_role.required' => 'Kies een familierol.',
            'member_role_id.required' => 'Kies een lidmaatschapsrol.',
        ]);
    
        // Haal het bestaande familielid op
        $familyMember = FamilyMember::findOrFail($familyMemberId);
    
        // Update het familielid met de nieuwe data
        $familyMember->update($data);
    
        return redirect()->route('family_members.index', $familyId)->with('success', 'Familielid succesvol bijgewerkt.');
    }
    
    public function destroy($familyId, $familyMemberId)
    {
        // Haal het familielid op
        $familyMember = FamilyMember::findOrFail($familyMemberId);

        // Verwijder alle gerelateerde contributies
        MemberYear::where('family_member_id', $familyMemberId)->delete();

        // Verwijder het familielid zelf
        $familyMember->delete();

        // Redirect naar de index pagina van familieleden met een succesbericht
        return redirect()->route('family_members.index', $familyId)
            ->with('success', 'Familielid succesvol verwijderd.');
    }
}