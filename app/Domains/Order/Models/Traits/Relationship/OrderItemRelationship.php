<?php
namespace App\Domains\Order\Models\Traits\Relationship;

use App\Domains\Course\Models\Course;
use App\Domains\Online\Models\Online;
use Illuminate\Database\Eloquent\Relations\HasOne;

trait OrderItemRelationship
{
    /**
     * Get the product associated with the OrderItemRelationship
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function product(): HasOne
    {
        if ($this->product_type == 'online') {
            return $this->hasOne(Online::class, 'id', 'product_id');
        } else {
            return $this->hasOne(Course::class, 'id', 'product_id');
        }
    }
}
