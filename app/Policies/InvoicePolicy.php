<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Invoice;
use Illuminate\Auth\Access\HandlesAuthorization;

class InvoicePolicy
{
    use HandlesAuthorization;

    public function verifyPayment(User $user, Invoice $invoice)
    {
        return $user->role === 'admin';
    }
}
