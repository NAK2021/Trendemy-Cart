<?php

namespace App\Services\Interfaces;

interface BankServiceInterface
{
    public function create($request);
    public function checkBank();
}
