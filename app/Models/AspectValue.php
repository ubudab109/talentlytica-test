<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AspectValue extends Model
{
    use HasFactory;

    protected $fillable = ['participant_id', 'name', 'value'];


    /**
     * This function defines a relationship between the current model and the Participant model in a
     * PHP Laravel application.
     * 
     * @return BelongsTo
     */
    public function participant() : BelongsTo
    {
        return $this->belongsTo(Participant::class, 'participant_id', 'id');
    }
}
