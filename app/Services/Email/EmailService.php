<?php
namespace App\Services\Email;

use Illuminate\Support\Facades\Mail;
use App\Mail\SupplierRequestProductMail;
use App\Interfaces\EmailServiceInterface;

class EmailService implements EmailServiceInterface
{
    public function sendToUser($user, array $details): void
    {
        Mail::to($user->email)->send(new SupplierRequestProductMail($user, $details));
    }

    public function sendToSupplier($supplier, array $details): void
    {
        Mail::to($supplier->email)->send(new SupplierRequestProductMail($supplier, $details));
    }
}
