<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contribution extends Model
{
    use HasFactory;

    // Aangeven welke velden massaal toewijsbaar zijn
    protected $fillable = [
        'fiscal_year_id', 
        'amount'
    ];

    // Relatie: een basisbedrag hoort bij één boekjaar
    public function fiscalYear()
    {
        return $this->belongsTo(FiscalYear::class);
    }
}