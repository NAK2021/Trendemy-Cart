<?php

namespace App\Http\Controllers;

use Exception;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Enums\PaymentMethod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Jobs\SendInvoiceMail;
use App\Jobs\SendMail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Session;
use App\Services\Interfaces\BankServiceInterface;
use App\Services\Interfaces\MomoServiceInterface;
use App\Services\Interfaces\OrderServiceInterface;
use App\Services\Interfaces\VNPayServiceInterface;

class OrderController extends Controller
{

    // private $orderService;
    // private $vnpayService;
    // private $momoService;
    // private $bankService;


    public function __construct(
        private OrderServiceInterface $orderService,
        private VNPayServiceInterface $vnpayService,
        private MomoServiceInterface $momoService,
        private BankServiceInterface $bankService
    ) {
        // $this->orderService = $orderService;
        // $this->vnpayService = $vnpayService;
        // $this->momoService = $momoService;
        // $this->bankService = $bankService;
    }

    public function index()
    {
        $orderInfo = $this->orderService->show();
        if (count($orderInfo['carts']) == 0) {
            Session::forget(['carts', 'codes']);
            return redirect()->route('home');
        }
        return view('client.home.checkout', $orderInfo);
    }

    public function checkout(Request $request)
    {
        try {
            $method = $request->method;
            if ($method) {
                $order = $this->orderService->createOrder();
                if ($order) {
                    $request->merge([
                        'orderId' => $order['orderId'],
                        'orderCode' => $order['orderCode'],
                        'total' => $order['total']
                    ]);
                    switch ($method) {
                        case PaymentMethod::VNPAY:
                            $vnp_Url = $this->vnpayService->create($request);
                            return redirect($vnp_Url);
                        case PaymentMethod::MOMO:
                            $payUrl = $this->momoService->create($request);
                            return redirect($payUrl);
                        case PaymentMethod::BANK:
                            return $this->bankService->create($request);
                        default:
                            return redirect()->back()->withErrors(['method' => 'Không rõ phương thức thanh toán.']);
                    }
                } else {
                    return redirect()->back()->with(
                        [
                            'notify' =>
                            [
                                'type' => 'error',
                                'message' => 'Có lỗi xảy ra! Vui lòng thử lại sau.'
                            ]
                        ]
                    );
                }
            } else {
                return redirect()->back()->withErrors(['method' => 'Vui lòng chọn phương thức thanh toán.']);
            }
        } catch (Exception $ex) {
            Log::info($ex->getMessage());
        }
    }
    public function checkBank()
    {
        return $this->bankService->checkBank();
    }
    public function result()
    {
        try {
            $result = session('result');
            if (isset($result)) {
                if ($result) {
                    $this->sendInvoice($result);
                }
                session()->forget('result');
                return view('client.home.result', compact('result'));
            }
        } catch (Exception $ex) {
            Log::error('[' . __METHOD__ . ']: ' . $ex->getMessage());
        }
        return redirect()->route('home');
    }
    public function download()
    {
        try {
            $code = Session::get('DownloadInvoice');
            if ($code) {
                return Storage::download('invoices/' . $code . '.pdf');
            }
        } catch (Exception $ex) {
            Log::error('[' . __METHOD__ . ']: ' . $ex->getMessage());
        }
        return redirect()->route('home');
    }
    public function sendInvoice($orderId)
    {
        try {
            $order = $this->orderService->invoice($orderId);
            if ($order) {
                $order['customer'] = auth()->user()->name;
                $order['email'] = auth()->user()->email;
                Session::put('DownloadInvoice', $order['code']);
                SendInvoiceMail::dispatch($order)->onQueue('emails');
            }
        } catch (Exception $ex) {
            Log::error('[' . __METHOD__ . ']: ' . $ex->getMessage());
        }
    }
}
