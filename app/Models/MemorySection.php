<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class MemorySection extends Model
{
    protected $fillable = [
        'memory_id','type','label','heading','content','handwritten_note',
        'image','image_tag','image_right','time_label','video_url','quote_author','sort_order',
    ];
    protected $casts = ['image_right'=>'boolean'];
    public function memory() { return $this->belongsTo(Memory::class); }
    public function getImageUrlAttribute(): ?string
    {
        return $this->image ? asset('storage/'.$this->image) : null;
    }
}

