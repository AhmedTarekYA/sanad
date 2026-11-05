<?php

namespace App\Models\Sanad;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string|null $image
 * @property string $slug
 * @property string $created_at
 * @property string $updated_at
 * @property array<string> $translatedAttributes
 */
class Blog extends Model
{
    use HasFactory, Translatable;

    protected $fillable = ['image', 'is_featured'];

    protected $casts = ['is_featured' => 'boolean'];

    public $translatedAttributes = ['title', 'description', 'slug', 'content'];

    protected $translationForeignKey = 'blog_id';

    public $translationModel = BlogTranslation::class;

    public function getReadingMinutesAttribute(): int
    {
        $words = count(preg_split('/\s+/u', trim(strip_tags((string) $this->content)), -1, PREG_SPLIT_NO_EMPTY));

        return max(1, (int) ceil($words / 200));
    }
}
