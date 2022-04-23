<?php
namespace App\Domains\Order\Models;

use App\Domains\Order\Models\Traits\Attribute\OrderItemAttribute;
use App\Domains\Order\Models\Traits\Relationship\OrderItemRelationship;
use Database\Factories\OrderItemFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrdersItem extends Model
{
    use HasFactory,
    OrderItemRelationship,
    OrderItemAttribute;

    protected $fillable = [
        "orders_id",
        "product_id",
        "product_type",
        "quantity",
        "unit_price",
        "total",
        "name",
        "property",
    ];

    protected $casts = [
        'property' => "array",
    ];


    public static function newFactory()
    {
        return OrderItemFactory::new();
    }
}
