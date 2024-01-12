<?php

namespace App\Models;

use App\Diary\AI\NutriDialogMessageType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NutriDialogMessage extends Model
{
    use HasFactory;

    protected $casts = [
        'suggestions' => 'array',
        'type' => NutriDialogMessageType::class,
    ];

    public function nutriDialog()
    {
        return $this->belongsTo(NutriDialog::class);
    }
}
