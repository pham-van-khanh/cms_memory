<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class MemoryImage extends Model
{
    protected $fillable = ['memory_id','path','caption','handwritten_caption','type','sort_order'];
    public function memory() { return $this->belongsTo(Memory::class); }
    public function getUrlAttribute(): string { return asset('storage/'.$this->path); }
}

