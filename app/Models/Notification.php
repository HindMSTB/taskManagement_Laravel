<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    protected $fillable = [
        'date',
        'contenu',
        'type',
        'tache_id',
        'Vu',
        'VUFromBouttonNotif'
    ];

    public function tache()
    {
        return $this->belongsTo(Tache::class);
    }
}
