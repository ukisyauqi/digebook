<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Guest extends Model
{
  use HasFactory;
  protected $fillable = [
    'name',
    'whatsapp',
    'qrcode_checkin',
    'qrcode_checkout'
  ];

  public function user(): BelongsTo
  {
      return $this->belongsTo(User::class);
  }
}
