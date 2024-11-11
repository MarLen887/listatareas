<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Country extends Model
{
    use HasFactory;
    protected $fillable = ['title','fecha_final','tipo','estado'];

    public function authors(): HasMany
    {
        return $this->hasMany(Author::class);
    }
}
