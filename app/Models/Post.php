<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Post extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'type','category_id','user_id','title','slug','excerpt',
        'content','cover_image','tags','published','published_at','views',
    ];
    protected $casts = ['published'=>'boolean','published_at'=>'datetime','tags'=>'array'];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($p) {
            $p->slug    ??= self::uniqueSlug($p->title);
            $p->user_id ??= auth()->id();
        });
        static::updating(function ($p) {
            if ($p->isDirty('title') && !$p->isDirty('slug'))
                $p->slug = self::uniqueSlug($p->title, $p->id);
        });
    }

    private static function uniqueSlug(string $title, ?int $except = null): string
    {
        $base = Str::slug($title); $slug = $base; $i = 1;
        while (self::where('slug',$slug)->when($except,fn($q)=>$q->where('id','!=',$except))->exists())
            $slug = $base.'-'.$i++;
        return $slug;
    }

    public function category()  { return $this->belongsTo(Category::class); }
    public function author()    { return $this->belongsTo(User::class, 'user_id'); }

    public function getCoverUrlAttribute(): string
    {
        return $this->cover_image ? asset('storage/'.$this->cover_image) : asset('images/placeholder.jpg');
    }

    public function scopePublished($q) { return $q->where('published',true); }
    public function scopeOfType($q, string $type) { return $q->where('type',$type); }
    public function scopeOrdered($q)   { return $q->orderByDesc('published_at')->orderByDesc('created_at'); }
    public function incrementViews()   { $this->increment('views'); }
}

