<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class category extends Model
{
    use HasFactory;
    protected $fillable = ['name'];
    public function category(): BelongsToMany
    {
        return $this->belongsToMany(category::class);
    }
}
