<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Models\Participant
 * 
 * @property int $id
 * @property string $email
 * @property int $x
 * @property int $y
 * @property int $z
 * @property int $w
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 */
class Participant extends Model
{
    use HasFactory;

    protected $fillable = ['fullname', 'email', 'x', 'y', 'z', 'w'];

    /**
     * This PHP function returns a many-to-many relationship between the current object and an
     * AspectValue object, using a pivot table and including additional pivot data.
     * 
     * @return HasMany
     */
    public function aspectValue(): HasMany
    {
        return $this->hasMany(AspectValue::class, 'participant_id', 'id');
    }
}
