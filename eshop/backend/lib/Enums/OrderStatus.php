<?php

namespace Eshop\Enums;

enum OrderStatus: string
{
	case PENDING = 'pending';
	case PAID = 'paid';
	case SENT = 'sent';
	case COMPLETED = 'completed';
	case CANCELLED = 'cancelled';
}