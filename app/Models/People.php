<?php

namespace App\Models;

use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class People extends Model
{
    use HasFactory, HasSlug;

    protected $table = 'people';

    protected $fillable = [
        'name',
        'subtitle',
        'slug',
        'country',
        'external_url',
        'info',
        'additional_data',
    ];

    protected $casts = [
        'additional_data' => 'json'
    ];

    const PAGINATE_VALUE = 10;
    
    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug');
    }
}
