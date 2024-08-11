<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FamilyMember extends Model
{
    use HasFactory;

    // Aangeven welke velden massaal toewijsbaar zijn
    protected $fillable = [
        'first_name', 
        'birth_date', 
        'family_role', 
        'family_id', 
        'member_role_id', 
        'membership_type_id'
    ];

    // Relatie: een familielid hoort bij één familie
    public function family()
    {
        return $this->belongsTo(Family::class);
    }

    // Relatie: een familielid één specifieke rol binnen de club
    public function memberRole()
    {
        return $this->belongsTo(MemberRole::class, 'member_role_id');
    }

    // Relatie: een familielid kan meerdere berekende contributies over de jaren hebben
    public function memberYears()
    {
        return $this->hasMany(MemberYear::class);
    }
}