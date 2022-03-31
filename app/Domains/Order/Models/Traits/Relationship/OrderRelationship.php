<?php

namespace App\Domains\Order\Models\Traits\Relationship;

use App\Domains\Order\Models\OrdersItem;
use App\Domains\User\Models\User;
use Illuminate\Database\Eloquent\Relations\HasMany;

trait OrderRelationship
{

    /**
     * Get all of the items for the OrderRelationship
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function items(): HasMany
    {
        return $this->hasMany(OrdersItem::class);
    }
    
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
