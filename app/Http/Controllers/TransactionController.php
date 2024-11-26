<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\Interfaces\MomoServiceInterface;
use App\Services\Interfaces\VNPayServiceInterface;
use App\Services\Interfaces\BankServiceInterface;

class TransactionController extends Controller
{

    private $vnpayService;
    private $momoService;
    private $bankService;


    public function __construct(
        VNPayServiceInterface $vnpayService,
        MomoServiceInterface $momoService,
        BankServiceInterface $bankService

    ) {
        $this->vnpayService = $vnpayService;
        $this->momoService = $momoService;
        $this->bankService = $bankService;
    }


    public function vnpayReturn(Request $request)
    {
        if (!empty($request->all())) {
            $data = $this->vnpayService->response($request);
            return $this->handleResponse($data);
        } else {
            return redirect()->route('home');
        }
    }

    public function momoReturn(Request $request)
    {
        if (!empty($request->all())) {
            $data = $this->momoService->response($request);
            return $this->handleResponse($data);
        } else {
            return redirect()->route('home');
        }
    }
    public function handleResponse($data)
    {
        return redirect()->route('result')->with([
            'result' => $data
        ]);
    }
}
