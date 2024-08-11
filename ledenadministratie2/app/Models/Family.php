<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Family extends Model
{
    use HasFactory;

    // Aangeven welke velden massaal toewijsbaar zijn
    protected $fillable = [
        'family_name',
        'address',
    ];

    // Specificeer de bijbehorende database tabel (voor de zekerheid)
    protected $table = 'families';

    // Relatie: een familie heeft meerdere familieleden
    public function familyMembers()
    {
        return $this->hasMany(FamilyMember::class);
    }
}