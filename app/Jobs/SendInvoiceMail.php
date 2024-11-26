<?php

namespace App\Jobs;

use Exception;
use App\Mail\MailInvoice;
use Illuminate\Bus\Queueable;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class SendInvoiceMail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(public $order)
    {
    }

    public function handle(): void
    {
        try {
            $path = 'invoices/' . $this->order['code'] . '.pdf';
            $pdf = PDF::loadView('pdf.invoice', ['order' => $this->order]);
            Storage::put($path, $pdf->output());
            Mail::to($this->order['email'])->send(
                new MailInvoice(
                    'emails.invoice',
                    '[Trendemy] Hóa đơn điện tử',
                    $path
                )
            );
        } catch (Exception $ex) {
            Log::error('[' . __METHOD__ . ']: ' . $ex->getMessage());
        }
    }
}
