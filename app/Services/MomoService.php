<?php

namespace App\Services;

use App\Enums\PaymentMethod;
use App\Services\Interfaces\MomoServiceInterface;
use App\Services\Interfaces\TransactionServiceInterface;
use Illuminate\Support\Str;


class MomoService implements MomoServiceInterface
{

    protected $endpoint;
    protected $partnerCode;
    protected $accessKey;
    protected $secretKey;
    protected $returnUrl;

    public function __construct(protected TransactionServiceInterface $transactionService)
    {
        $this->endpoint = env('MOMO_ENDPOINT');
        $this->partnerCode = env('MOMO_PARTNER_CODE');
        $this->accessKey = env('MOMO_ACCESS_KEY');
        $this->secretKey = env('MOMO_SECRET_KEY');
        $this->returnUrl = env('MOMO_RETURN_URL');
    }


    function execPostRequest($url, $data)
    {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt(
            $ch,
            CURLOPT_HTTPHEADER,
            array(
                'Content-Type: application/json',
                'Content-Length: ' . strlen($data)
            )
        );
        curl_setopt($ch, CURLOPT_TIMEOUT, 5);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
        //execute post
        $result = curl_exec($ch);
        //close connection
        curl_close($ch);
        return $result;
    }

    public function create($request)
    {

        $partnerCode = $this->partnerCode;
        $accessKey = $this->accessKey;
        $secretKey = $this->secretKey;
        $orderInfo = "Thanh toán đơn hàng khóa học";
        $amount = $request->total . '';
        $redirectUrl = $this->returnUrl;
        $ipnUrl = $this->returnUrl;
        $orderId = $request->orderCode;
        $requestId = $request->orderId;
        $requestType = "captureWallet";
        $extraData = "";
        //before sign HMAC SHA256 signature
        $rawHash = "accessKey=" . $accessKey . "&amount=" . $amount . "&extraData=" . $extraData . "&ipnUrl=" . $ipnUrl . "&orderId=" . $orderId . "&orderInfo=" . $orderInfo . "&partnerCode=" . $partnerCode . "&redirectUrl=" . $redirectUrl . "&requestId=" . $requestId . "&requestType=" . $requestType;
        $signature = hash_hmac("sha256", $rawHash, $secretKey);
        $data = array(
            'partnerCode' => $partnerCode,
            'partnerName' => "MOMO",
            "storeId" => "TrendyAcademy",
            'requestId' => $requestId,
            'amount' => $amount,
            'orderId' => $orderId,
            'orderInfo' => $orderInfo,
            'redirectUrl' => $redirectUrl,
            'ipnUrl' => $ipnUrl,
            'lang' => 'vi',
            'extraData' => $extraData,
            'requestType' => $requestType,
            'signature' => $signature
        );
        $result = $this->execPostRequest($this->endpoint, json_encode($data));
        $jsonResult = json_decode($result, true);  // decode json
        return $jsonResult['payUrl'];
    }

    public function response($request)
    {

        $secretKey = $this->secretKey; //Put your secret key in there
        $accessKey = $this->accessKey;

        $partnerCode = $request->partnerCode;
        $orderId = $request->orderId;
        $requestId = $request->requestId;
        $amount = $request->amount;
        $orderInfo = $request->orderInfo;
        $orderType = $request->orderType;
        $transId = $request->transId;
        $resultCode = $request->resultCode;
        $message = $request->message;
        $payType = $request->payType;
        $responseTime = $request->responseTime;
        $extraData = $request->extraData;
        $m2signature = $request->signature; //MoMo signature

        //Checksum
        $rawHash = "accessKey=" . $accessKey . "&amount=" . $amount . "&extraData=" . $extraData . "&message=" . $message . "&orderId=" . $orderId . "&orderInfo=" . $orderInfo .
            "&orderType=" . $orderType . "&partnerCode=" . $partnerCode . "&payType=" . $payType . "&requestId=" . $requestId . "&responseTime=" . $responseTime .
            "&resultCode=" . $resultCode . "&transId=" . $transId;

        $partnerSignature = hash_hmac("sha256", $rawHash, $secretKey);
        if ($m2signature == $partnerSignature) {
            return $this->transactionService->create($request, PaymentMethod::MOMO);
        } else {
            return false;
        }
    }
}
