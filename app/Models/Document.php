<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Auth;
class Document extends Model
{
    use HasFactory;

    protected $with = [
        'reject_type',
        'organization',
        'positions',
        'user',
        'images',
        'negation',
        'backup'
    ];

    protected $fillable = [
        'name',
        'reject_type_id',
        'organization_id',
        'user_id',
        'term',
        'src',
    ];

    public function scopeForMyPositions($query){
        $query->whereHas('positions', function (Builder $query) {
            $positions = Auth::user()->positions()->pluck('position_id')->toArray();
            $query->whereIn('position_id', $positions);
        });
    }



    public function reject_type()
    {
        return $this->belongsTo(RejectTypes::class);
    }

    public function organization()
    {
        return $this->belongsTo(NameOrganization::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function positions()
    {
        return $this->hasMany(Subscribe::class);
    }

    public function images()
    {
        return $this->hasMany(Image::class);
    }

    public function negation()
    {
        return $this->hasOne(Negation::class);
    }

    public function backup()
    {
        return $this->hasOne(Backup::class);
    }
}
