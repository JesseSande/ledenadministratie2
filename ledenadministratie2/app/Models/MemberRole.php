<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MemberRole extends Model
{
    use HasFactory;

    // Aangeven welke velden massaal toewijsbaar zijn
    protected $fillable = ['description'];

    // Relatie: een rol binnen de club kan door meerdere leden worden vervuld
    public function familyMembers()
    {
        return $this->hasMany(FamilyMember::class);
    }
}