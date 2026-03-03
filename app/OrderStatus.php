<?php

namespace App;

enum OrderStatus: string
{
    case PENDING = "pending";
    case PROCESSING = "processing";
    case SHIPPED = "shipped";
    case DELIVERED = "delivered";
    case CANCELLED = "cancelled";

    public function label(): string
    {
        return match ($this) {
            self::PENDING => 'Pending',
            self::PROCESSING => 'Processing',
            self::SHIPPED => 'Shipped',
            self::DELIVERED => 'Delivered',
            self::CANCELLED => 'Cancelled',
        };
    }

    public function weight(): int
    {
        return match ($this) {
            self::PENDING => 1,
            self::PROCESSING => 2,
            self::SHIPPED => 3,
            self::DELIVERED => 4,
            self::CANCELLED => 5,
        };
    }

    public function canTransitionTo(self $target): bool
    {
        // Cancelled and Delivered are terminal states
        if ($this === self::CANCELLED || $this === self::DELIVERED) {
            return false;
        }

        // Allow cancellation from any non-terminal state
        if ($target === self::CANCELLED) {
            return true;
        }

        // Otherwise, only allow moving forward in the sequence
        return $target->weight() > $this->weight();
    }
}
