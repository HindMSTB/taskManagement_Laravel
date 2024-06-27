<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tache extends Model
{
    use HasFactory;

    protected $fillable = [
        'titre',
        'description',
        'dateDue',
        'DateFin',
        'dateModification',
        'messageFin',
        'priorite',
        'createdBy',
        'modifiedBy',
        'deletedBy',
        'dateCreation',
        'dateModification',
        'dateSuppression',
        'etat',
        'status',
        'dateAffectation',
        'tacheOrig',
        'user_id',
        'ModifDetails',
    ];

    /**
     * Relation avec le modèle User.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
