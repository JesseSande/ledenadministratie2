<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FiscalYear extends Model
{
    use HasFactory;

    // Aangeven welke velden massaal toewijsbaar zijn
    protected $fillable = ['year'];

    // Relatie: een boekjaar kan meerdere berekende contributies bevatten
    public function memberYears()
    {
        return $this->hasMany(MemberYear::class);
    }
}