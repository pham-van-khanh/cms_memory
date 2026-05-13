<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Memory extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id','category_id','title','slug','description','location','memory_date',
        'hero_image','background_music','opening_quote','opening_quote_author',
        'template','color_accent','password','published','sort_order','views',
    ];
    protected $casts = ['memory_date'=>'date','published'=>'boolean'];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($m) {
            $m->slug    ??= self::uniqueSlug($m->title);
            $m->user_id ??= auth()->id();
        });
        static::updating(function ($m) {
            if ($m->isDirty('title') && !$m->isDirty('slug'))
                $m->slug = self::uniqueSlug($m->title, $m->id);
        });
    }

    private static function uniqueSlug(string $title, ?int $except = null): string
    {
        $base = Str::slug($title); $slug = $base; $i = 1;
        while (self::where('slug',$slug)->when($except,fn($q)=>$q->where('id','!=',$except))->exists())
            $slug = $base.'-'.$i++;
        return $slug;
    }

    public function images()           { return $this->hasMany(MemoryImage::class)->orderBy('sort_order'); }
    public function sections()         { return $this->hasMany(MemorySection::class)->orderBy('sort_order'); }
    public function category()         { return $this->belongsTo(Category::class); }
    public function author()           { return $this->belongsTo(User::class, 'user_id'); }
    public function galleryImages()    { return $this->hasMany(MemoryImage::class)->where('type','gallery')->orderBy('sort_order'); }
    public function storySections()    { return $this->sections()->where('type','story'); }
    public function timelineSections() { return $this->sections()->where('type','timeline'); }

    public function getHeroImageUrlAttribute(): string
    {
        return $this->hero_image ? asset('storage/'.$this->hero_image) : asset('images/placeholder.jpg');
    }
    public function getMusicUrlAttribute(): ?string
    {
        return $this->background_music ? asset('storage/'.$this->background_music) : null;
    }

    public function isProtected(): bool   { return !empty($this->password); }
    public function getAccentColor(): string { return $this->color_accent ?: '#c9847a'; }
    public function getTemplateView(): string
    {
        $t = in_array($this->template, array_keys(config('cms.memory_themes'))) ? $this->template : 'classic';
        return "memories.themes.{$t}";
    }

    public function scopePublished($q) { return $q->where('published',true); }
    public function scopeOrdered($q)   { return $q->orderBy('sort_order')->orderByDesc('memory_date'); }
    public function incrementViews()   { $this->increment('views'); }
}

