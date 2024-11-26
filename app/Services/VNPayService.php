<?php

namespace App\Services;

use App\Enums\PaymentMethod;
use App\Services\Interfaces\VNPayServiceInterface;
use App\Services\Interfaces\TransactionServiceInterface;

class VNPayService implements VNPayServiceInterface
{
    protected $vnp_TmnCode;
    protected $vnp_HashSecret;
    protected $vnp_Url;
    protected $vnp_Returnurl;

    public function __construct(protected TransactionServiceInterface $transactionService)
    {
        $this->vnp_TmnCode = env('VNP_TMN_CODE');
        $this->vnp_HashSecret = env('VNP_HASH_SECRET');
        $this->vnp_Url = env('VNP_URL');
        $this->vnp_Returnurl = env('VNP_RETURN_URL');
    }

    public function create($request)
    {

        $startTime = date("YmdHis");
        $expire = date('YmdHis', strtotime('+15 minutes', strtotime($startTime)));


        $vnp_TxnRef = $request->orderCode;
        $vnp_OrderInfo = $request->orderId;
        $vnp_OrderType = 'Courses';
        $vnp_Amount = $request->total * 100;
        $vnp_Locale = 'VN';
        // $vnp_BankCode = 'NCB';
        $vnp_IpAddr = $request->ip();
        $vnp_ExpireDate = $expire;

        $inputData = array(
            "vnp_Version" => "2.1.0",
            "vnp_TmnCode" => $this->vnp_TmnCode,
            "vnp_Amount" => $vnp_Amount,
            "vnp_Command" => "pay",
            "vnp_CreateDate" => date('YmdHis'),
            "vnp_CurrCode" => "VND",
            "vnp_IpAddr" => $vnp_IpAddr,
            "vnp_Locale" => $vnp_Locale,
            "vnp_OrderInfo" => $vnp_OrderInfo,
            "vnp_OrderType" => $vnp_OrderType,
            "vnp_ReturnUrl" => $this->vnp_Returnurl,
            "vnp_TxnRef" => $vnp_TxnRef,
            "vnp_ExpireDate" => $vnp_ExpireDate
        );

        if (isset($vnp_BankCode) && $vnp_BankCode != "") {
            $inputData['vnp_BankCode'] = $vnp_BankCode;
        }

        ksort($inputData);
        $query = "";
        $i = 0;
        $hashdata = "";
        foreach ($inputData as $key => $value) {
            if ($i == 1) {
                $hashdata .= '&' . urlencode($key) . "=" . urlencode($value);
            } else {
                $hashdata .= urlencode($key) . "=" . urlencode($value);
                $i = 1;
            }
            $query .= urlencode($key) . "=" . urlencode($value) . '&';
        }

        $vnp_Url = $this->vnp_Url . "?" . $query;
        if (isset($this->vnp_HashSecret)) {
            $vnpSecureHash =   hash_hmac('sha512', $hashdata, $this->vnp_HashSecret);
            $vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;
        }
        return $vnp_Url;
    }
    public function response($request)
    {
        $vnp_SecureHash = $request->vnp_SecureHash;
        $inputData = $request->except('vnp_SecureHash', 'vnp_SecureHashType');
        $hashData = "";
        foreach ($inputData as $key => $value) {
            $hashData .= '&' . urlencode($key) . "=" . urlencode($value);
        }
        $hashData = ltrim($hashData, '&');
        $secureHash = hash_hmac('sha512', $hashData, $this->vnp_HashSecret);
        if ($secureHash == $vnp_SecureHash) {
            return $this->transactionService->create($request, PaymentMethod::VNPAY);
        } else {
            return false;
        }
    }
}
