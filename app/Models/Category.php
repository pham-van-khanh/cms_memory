<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Category extends Model
{
    protected $fillable = ['name','slug','description','color','type','sort_order'];

    protected static function boot()
    {
        parent::boot();
        static::creating(fn($c) => $c->slug ??= Str::slug($c->name));
    }

    public function memories() { return $this->hasMany(Memory::class); }
    public function posts()    { return $this->hasMany(Post::class); }

    public function scopeForType($q, string $type)
    {
        return $q->whereIn('type', [$type, 'general']);
    }
}

