<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NutriDialogMessage extends Model
{
    use HasFactory;

    protected $casts = [
        'suggestions' => 'array',
    ];

    public function nutriDialog()
    {
        return $this->belongsTo(NutriDialog::class);
    }
}
