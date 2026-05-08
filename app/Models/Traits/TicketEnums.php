<?php

namespace App\Models\Traits;

trait TicketEnums
{
    public static $statuses = ['open', 'in_progress', 'resolved', 'closed'];
    public static $priorities = ['low', 'medium', 'high', 'urgent'];
}
