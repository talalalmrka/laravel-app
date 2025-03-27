<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use App\Traits\HasThumbnail;
use Illuminate\Support\Str;
class Post extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia, HasThumbnail;
    protected $fillable = [
        'user_id',
        'name',
        'slug',
        'description',
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
        return route('post', $this);
    }
    public function getAuthorNameAttribute()
    {
        return $this->user?->name;
    }
    public function getDateAttribute()
    {
        return $this->created_at->format('d M, Y');
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
}
