<?php

/*
* This file is part of the IAKPress package.
*
* (c) IAKPress <contact@iakpress.com>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

namespace App\Joosorol\IAKPress\IAModel;

/**
 * class Constans
 */
class EntryStatus
{
    const STATUS_UNREAD = "unread"; 
    const STATUS_READ = "read";
    const STATUS_PUBLISH = "publish";
    const STATUS_IN_PROGRESS = "in_progress"; 
    const STATUS_PENDING = "pending";
    const STATUS_PAYMENT_PENDING = "payment_pending";
    const STATUS_PAYMENT_RECEIVED = "payment_received";
    const STATUS_SHIPPED = "shipped";
    const STATUS_DELIVERED = "delivered";
    const STATUS_COMPLETED = "completed"; 
    const STATUS_CANCELLED = "cancelled";
    const STATUS_RETURN_REQUESTED = "return_requested";
    const STATUS_RETURN_APPROVED = "return_approved";
    const STATUS_RETURN_RECEIVED = "return_received";
    const STATUS_RETURN_REJECTED = "return_rejected";
    const STATUS_CLOSED = "closed";


    const STATUSES = [
        self::STATUS_UNREAD => 'Unread',
        self::STATUS_READ => 'Read',
        self::STATUS_PUBLISH => 'Publish',
        self::STATUS_IN_PROGRESS => 'In progress',
        self::STATUS_PENDING => 'Pending',
        self::STATUS_PAYMENT_PENDING => 'Payment pending',
        self::STATUS_PAYMENT_RECEIVED => 'Payment received',
        self::STATUS_SHIPPED => 'Shipped',
        self::STATUS_DELIVERED => 'Delivered',
        self::STATUS_COMPLETED => 'Completed',
        self::STATUS_CANCELLED => 'Cancelled',
        self::STATUS_RETURN_REQUESTED => 'Return requested',
        self::STATUS_RETURN_APPROVED => 'Return appoved',
        self::STATUS_RETURN_RECEIVED => 'Return received',
        self::STATUS_RETURN_REJECTED => 'Return rejected',
        self::STATUS_CLOSED => 'Closed'
    ];

    /**
     * Constructor.
     */
    private function __construct()
    {
    }

    public static function isValidStatus(string $status) : bool {
        switch ($status) {
            case self::STATUS_UNREAD:
            case self::STATUS_READ:
            case self::STATUS_PENDING:
            case self::STATUS_IN_PROGRESS:
            case self::STATUS_PAYMENT_PENDING:
            case self::STATUS_PAYMENT_RECEIVED:
            case self::STATUS_SHIPPED:
            case self::STATUS_DELIVERED:
            case self::STATUS_COMPLETED:
            case self::STATUS_CANCELLED:
            case self::STATUS_RETURN_REQUESTED:
            case self::STATUS_RETURN_APPROVED:
            case self::STATUS_RETURN_RECEIVED:
            case self::STATUS_RETURN_REJECTED:
            case self::STATUS_CLOSED:
            return true;


            default:
            return false;
        }
    }
}

/* EOF */
