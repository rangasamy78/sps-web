<?php

namespace App\Interfaces;

interface EmailServiceInterface
{
    public function sendToUser($user, array $details): void;
    public function sendToSupplier($supplier, array $details): void;
}
