<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MembershipType extends Model
{
    use HasFactory;

    // Aangeven welke velden massaal toewijsbaar zijn
    protected $fillable = [
        'title', 
        'age_min', 
        'age_max', 
        'discount', 
        'fiscal_year_id'
    ];

    // Relatie: een set lidmaatschapstypen hoort bij één boekjaar
    public function fiscalYear()
    {
        return $this->belongsTo(FiscalYear::class);
    }
}