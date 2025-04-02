<?php

namespace App\Models;

use App\Traits\HasMeta;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use App\Traits\HasThumbnail;
use App\Traits\WithEditUrl;
use Illuminate\Support\Str;

class Post extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia, HasThumbnail, HasMeta, WithEditUrl;
    protected $fillable = [
        'user_id',
        'name',
        'slug',
        'type',
        'status',
        'content',
    ];
    protected $appends = [
        'permalink',
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function getPermalinkAttribute()
    {
        return !empty($this->id) ? route('post', $this) : null;
    }
    public function getAuthorNameAttribute()
    {
        return $this->user?->name;
    }
    public function getDateAttribute()
    {
        return $this->created_at->format('d M, Y');
    }
    public function getThumbnailFallbackUrlAttribute() {
        return asset('assets/img/post-thumbnail.png');
    }
    public function registerMediaCollections(): void
    {
        $this->registerThumbnail();
        $this->addMediaCollection('images')
            ->acceptsMimeTypes([
                'image/jpeg',
                'image/png',
                'image/webp',
                'image/gif'
            ]);
    }
    public static function generateSlug($name, $separator = '-', $language = 'en', $dictionary = ['@' => 'at']): string
    {
        $slug = Str::slug($name, $separator, $language, $dictionary);
        $originalSlug = $slug;
        $count = 1;
        while (self::where('slug', $slug)->exists()) {
            $slug = $originalSlug . $separator . $count++;
        }
        return $slug;
    }

    public function getLayout() {
        $template = $this->getMeta('template', 'cover');
        $layout = "layouts.$template";
        return view()->exists($layout) ? $layout : "layouts.app";
    }

    public function scopePublish($query)
    {
        return $query->where('status', 'publish');
    }
    public function scopePost($query)
    {
        return $query->where('type', 'post');
    }
}
