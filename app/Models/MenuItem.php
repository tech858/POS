<?php

namespace App\Models;

use App\Traits\HasBranch;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MenuItem extends Model
{
    use HasFactory;
    use HasBranch;

    const VEG = 'veg';
    const NONVEG = 'non-veg';
    const EGG = 'egg';

    protected $guarded = ['id'];

    protected $appends = [
        'item_photo_url',
    ];

    public function itemPhotoUrl(): Attribute
    {
        return Attribute::get(function (): string {
            return $this->image ? asset('user-uploads/item/' . $this->image) : asset('img/food.svg');
        });
    }

    public function menu(): BelongsTo
    {
        return $this->belongsTo(Menu::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(ItemCategory::class, 'item_category_id');
    }

    public function variations(): HasMany
    {
        return $this->hasMany(MenuItemVariation::class);
    }

    public function orders(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

}
