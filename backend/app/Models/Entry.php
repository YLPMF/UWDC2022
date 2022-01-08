<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Entry extends Model
{
    use HasFactory;

    protected $fillable = [
        'date',
        'type_id',
        'category_id',
        'time',
        'notes',
    ];

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'entry_tags');
    }

    public function type()
    {
        return $this->belongsTo(Type::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
