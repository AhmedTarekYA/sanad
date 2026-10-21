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

    protected $fillable = ['image', 'slug'];

    public $translatedAttributes = ['title', 'description'];

    protected $translationForeignKey = 'blog_id';

    public $translationModel = BlogTranslation::class;
}
