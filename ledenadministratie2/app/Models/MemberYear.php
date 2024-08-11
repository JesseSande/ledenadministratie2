<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MemberYear extends Model
{
    use HasFactory;

    // Aangeven welke velden massaal toewijsbaar zijn
    protected $fillable = [
        'family_member_id',
        'fiscal_year_id',
    ];

    // Relatie: een berekende contributie hoort bij een familie via het familielid
    public function family()
    {
        return $this->familyMember->belongsTo(Family::class, 'family_id');
    }

    // Relatie: een berekende contributie hoort bij een specifiek familielid
    public function familyMember()
    {
        return $this->belongsTo(FamilyMember::class);
    }

    // Relatie: een berekende contributie hoort bij een specifiek boekjaar
    public function fiscalYear()
    {
        return $this->belongsTo(FiscalYear::class);
    }

    // Relatie: een berekende contributie heeft één bijbehorend contributiebedrag
    public function contribution()
    {
        return $this->hasOne(Contribution::class, 'fiscal_year_id', 'fiscal_year_id');
    }

    // Relatie: een berekende contributie heeft één bijbehorende set lidmaatschapstypen
    public function membershipType()
    {
        return $this->hasOne(MembershipType::class, 'fiscal_year_id', 'fiscal_year_id');
    }

    // Leeftijd berekenen
    public function calculateAge()
    {
        $familyMember = $this->familyMember;
        $fiscalYear = $this->fiscalYear;
    
        return $fiscalYear->year - (date('Y', strtotime($familyMember->birth_date)) + 1);
    }

    // Methode om het juiste lidmaatschapstype te berekenen op basis van leeftijd
    public function calculateMembershipType()
    {
        return $this->membershipType()
            ->where('age_min', '<=', $this->calculateAge())
            ->where('age_max', '>=', $this->calculateAge())
            ->first();    
    }

    // Methode om het juiste lidmaatschapstype te vinden op basis van leeftijd en de contributie te berekenen
    public function calculateContribution()
    {
        // Haal het familielid op
        $familyMember = $this->familyMember;
        $fiscalYear = $this->fiscalYear;

        // Bereken de leeftijd van het familielid op 1 januari van het gekozen boekjaar
        $age = $this->calculateAge();

        // Zoek het juiste lidmaatschapstype op basis van de leeftijd
        $membershipType = $this->calculateMembershipType();

        // Haal het basisbedrag op
        $contribution = $this->contribution;

        // Bereken de contributie: basisbedrag - (basisbedrag * korting)
        $calculatedContribution = $contribution->amount - ($contribution->amount * ($membershipType->discount / 100));

        return $calculatedContribution;
    }

    // Query filteren op een boekjaar. Code m.b.v. ChatGPT4o Laravel GPT. 
    public function scopeForFiscalYear($query, $fiscalYearId)
    {
        return $query->where('fiscal_year_id', $fiscalYearId);
    }

    // Query filteren op een familie. Code m.b.v. ChatGPT4o Laravel GPT. 
    public function scopeForFamily($query, $familyId)
    {
        return $query->whereHas('familyMember', function($q) use ($familyId) {
            $q->where('family_id', $familyId);
        });
    }
}