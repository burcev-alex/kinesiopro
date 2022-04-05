<?php
namespace App\Domains\Order\Models;

use App\Domains\Order\Models\Interfaces\OrderInterface;
use App\Domains\Order\Models\Traits\Attribute\OrderAttribute;
use App\Domains\Order\Models\Traits\Observer\OrderObserver;
use App\Domains\Order\Models\Traits\Relationship\OrderRelationship;
use Database\Factories\OrderFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orchid\Screen\AsSource;

class Order extends Model implements OrderInterface
{
    use HasFactory,
    AsSource,
    OrderRelationship,
    OrderAttribute,
    OrderObserver;

    protected $fillable = [
        "completed_at",
        "number",
        "state",
        "items_total",
        "total",
        "confirmed",
        "confirmation_token",
        "email",
        "user_id",
        "comment",
        "first_name",
        "last_name",
        "phone",
        "promocode",
        "payment_method",
        "payment_status",
        "payment",
    ];

    protected $casts = [
        'payment' => "array",
    ];

    public static array $availableStates = [
        OrderInterface::STATE_PENDING,
        OrderInterface::STATE_PAID,
        OrderInterface::STATE_CANCELLED,
        OrderInterface::STATE_COMPLETED,
        OrderInterface::STATE_REFUSAL,
    ];
    
    public static function getStateTitle($state)
    {
        return in_array($state, self::$availableStates) ? __('history.filter.state.' . $state) : "-";
    }

    /**
     * Get state css class to draw
     *
     * @return string
     */
    public function getStateClassAttribute()
    {
        $result = [
            OrderInterface::STATE_PENDING => 'pending',
            OrderInterface::STATE_PAID => 'paid',
            OrderInterface::STATE_CANCELLED => 'cancelled',
            OrderInterface::STATE_COMPLETED => 'completed',
            OrderInterface::STATE_REFUSAL => 'refusal'
        ];
        return $result[$this->state] ?? '';
    }

    /**
     * Проверка оплачен заказ , или нет
     *
     * @return bool
     */
    public function isPayed()
    {
        return $this->payment_status == 'payed';
    }

    /**
     * Название статуса
     *
     * @return string
     */
    public function getStateTitleAttribute()
    {
        return self::getStateTitle($this->state);
    }


    public static function newFactory()
    {
        return OrderFactory::new();
    }
}
