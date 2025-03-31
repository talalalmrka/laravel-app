<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Traits\HasMeta;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Support\Facades\DB;
class User extends Authenticatable implements HasMedia
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasRoles, InteractsWithMedia, HasMeta;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($user) {
            $firstUser = DB::table('users')->orderBy('id')->first();

            if ($firstUser) {
                // Transfer posts to the first user before deleting
                \App\Models\Post::where('user_id', $user->id)->update(['user_id' => $firstUser->id]);
            }
        });
    }
    public function posts() {
        return $this->hasMany(Post::class);
    }
    public function registerMediaCollections(): void
    {
        $this
            ->addMediaCollection('avatar')
            ->useFallbackUrl(asset('assets/img/profile.svg'))
            ->useFallbackPath(public_path('/assets/img/profile.svg'))
            ->singleFile()
            ->acceptsMimeTypes([
                'image/jpeg',
                'image/png',
                'image/webp',
                'image/gif'
            ]);
        $this
            ->addMediaCollection('images')
            ->acceptsMimeTypes([
                'image/jpeg',
                'image/png',
                'image/webp',
                'image/gif'
            ]);
        $this
            ->addMediaCollection('files');

    }

    public function getAvatarUrl($conversionName = null): string
    {
        $conversionName = $conversionName ?? '';
        return $this->getFirstMediaUrl('avatar', $conversionName);
    }
    public function getAvatarUrlAttribute(): string
    {
        return $this->getAvatarUrl('sm');
    }

    public function getDisplayNameAttribute() {
        return $this->getMeta('display_name', $this->name);
    }
}
