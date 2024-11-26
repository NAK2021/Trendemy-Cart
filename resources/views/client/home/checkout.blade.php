@extends('client.main')

@section('title', 'Thanh Toán')

@section('styles')
    <style>
    </style>
@endsection

@section('main')

    <div class="row">
        <div class="col-md-12">
            <button class="btn-back">
                <i class="fa-solid fa-arrow-left"></i>
                &nbsp;Quay lại
            </button>
        </div>
        <div class="col-md-3 my-3"></div>
        <div class="col-md-6 my-3">
            <ul class="progressbar">
                <li class="active">Phương thức thanh toán</li>
                <li>Hoàn tất mua hàng</li>
            </ul>
        </div>
        <div class="col-md-3 my-3"></div>
        <div class="col-xl-7 col-md-12">
            <div class="list-course d-flex flex-column gap-2 bg-light box-shadow rounded p-3 mb-3">
                @foreach ($carts ?? [] as $cart)
                    <div
                        class="d-flex gap-3 flex-column flex-md-row align-items-center justify-content-center justify-content-md-start">
                        <img class="rounded" height="100px" width="200px" src="{{ $cart['thumbnail'] }}" alt="" />
                        <div class="d-flex flex-column flex-grow-1">
                            <h3 class="fw-bold fs-5">{{ $cart['course_name'] }}</h3>
                            <p class="mb-1"><i class="fa-regular fa-clock"></i> {{ $cart['duration'] }} giờ</p>
                            <p class="mb-0">Bởi {{ $cart['lecturer'] }}</p>
                        </div>
                        <div class="d-flex align-items-center">
                            <p class="fw-semibold m-0">{{ $cart['cost'] }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="box-summary bg-light box-shadow rounded p-3 mb-3">
                <div class="d-flex justify-content-between mb-3">
                    <span>Giá niêm yết:</span><span>{{ $base ?? '0 đ' }}</span>
                </div>
                <div class="d-flex justify-content-between mb-3">
                    <span>Giảm giá:</span><span>{{ $reduce ?? '0 đ' }}</span>
                </div>
                <div class="d-flex justify-content-between">
                    <span>Mã ưu đãi:</span><span>{{ $discount ?? '0 đ' }}</span>
                </div>
                <hr />
                <div class="fw-bold d-flex justify-content-between">
                    <span>Tổng tiền:</span><span>{{ $total ?? '0 đ' }}</span>
                </div>
            </div>
        </div>
        <div class="col-xl-5 col-md-12">
            <div class="bg-light box-shadow p-3 mb-3 rounded">
                <h4 class="fw-semibold mb-3">Phương thức thanh toán</h4>
                <div class="row d-flex flex-column gap-3 align-items-center" id="list-method">
                    @if ($errors->has('method'))
                        <small class="text-danger fst-italic">
                            (*) {{ $errors->first('method') }}
                        </small>
                    @endif
                    @foreach ($paymentMethods as $method)
                        <div class="col-md-6 box-shadow p-3 method-item" data-id="{{ $method }}">
                            @if ($method == 'MOMO')
                                <img src="./assets/icons/momo.svg" alt="{{ $method }}" class="box-shadow rounded" />
                            @elseif ($method == 'VNPAY')
                                <img src="./assets/icons/vnpay.svg" alt="{{ $method }}"
                                    class="box-shadow p-2 rounded" />
                            @elseif ($method == 'BANK')
                                <img src="./assets/images/mb-bank.png" alt="{{ $method }}"
                                    class="box-shadow p-2 rounded" />
                            @endif
                            Thanh toán qua {{ $method }}
                        </div>
                    @endforeach
                </div>
            </div>
            <form action="" method="POST">
                <div class="col-md-12 d-flex justify-content-center">
                    @csrf
                    <input type="hidden" value="" id="method" name="method" />
                    <button class="w-50 btn btn-info text-white my-3 py-2 fw-semibold text-uppercase" id="btn-payment"
                        type="submit">
                        Thanh Toán
                    </button>
                </div>
            </form>
        </div>
        <div class="col-md-12 p-3">
            <p class="notice-checkout">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M12 9v3.75m9-.75a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 3.75h.008v.008H12v-.008Z" />
                </svg>
                Sau khi chuyển khoản quý khách vui lòng chụp lại màn hình thanh
                toán thành công hoặc biên lai chuyển tiền. Trendemy sẽ liên hệ với
                quý khách ngay khi nhận được khoản tiền thanh toán thông qua thông
                tin email, số điện thoại được đăng ký.
            </p>
        </div>
    </div>

@endsection
{{-- <img src='${response.qrURL}' alt='QR Paymnet'/> --}}
@section('scripts')
    <script>
        var countdownId;
        var transactionId;
        var totalTime = 0;

        window.addEventListener("pageshow", function(event) {
            if (event.persisted) {
                window.location.reload();
            }
        });

        $document.ready(function() {
            $('#list-method .method-item').on('click', function() {
                $('#list-method .method-item').removeClass('active');
                $(this).addClass('active');
                $('#method').val($(this).data('id'));
                $('.text-danger').remove();
            });
        });
        $document.on('click', '.btn-back', function() {
            window.location.href = '/gio-hang';
        });
        $('#btn-payment').click(function(e) {
            let method = $('#method').val();
            if (method == 'BANK') {
                e.preventDefault();
                $.post('/thanh-toan', {
                    method
                }, (response, status) => {
                    if (status === 'success') {
                        if (response.success) {
                            showBoxQR(
                                response.qrURL,
                                response.accountName,
                                response.amount,
                                response.timeout
                            );
                            startCountdown(response.timeout);
                            checkTransaction();
                        } else {
                            Toast({
                                type: 'error',
                                message: 'Có lỗi xảy ra!',
                            });
                        }
                    }
                });
            }
        });

        const startCountdown = (timeout) => {
            countdownId = setInterval(function() {
                totalTime += 1;
                let secondsRemaining = timeout - totalTime;
                let minutes = Math.floor(secondsRemaining / 60);
                let seconds = secondsRemaining % 60;

                minutes = minutes < 10 ? "0" + minutes : minutes;
                seconds = seconds < 10 ? "0" + seconds : seconds;

                $('#countdown-value').text(minutes + ':' + seconds);

                if (totalTime >= timeout) {
                    clearIntervals();
                    closeModal();
                }
            }, 1000);
        };

        const checkTransaction = () => {
            const checkTransactionRequest = () => {
                $.get('/check-bank', function(response, status) {
                    if (status === 'success') {
                        if (response.success) {
                            clearIntervals();
                            closeModal();
                            setTimeout(() => startLoading(), 300);
                            window.location.href = response.url ?? '';
                        } else {
                            if (response.message) {
                                Toast({
                                    type: 'error',
                                    message: response.message
                                });
                                clearIntervals();
                                closeModal();
                            }
                        }
                    }
                });
            };

            transactionId = setInterval(function() {
                checkTransactionRequest();
            }, 10000);
        };

        const clearIntervals = () => {
            clearInterval(countdownId);
            clearInterval(transactionId);
            totalTime = 0;
        }
        const showBoxQR = (qr, name, amount, timeout) => {
            openModal({
                title: "Thanh toán hóa đơn",
                body: `<div class="text-center px-0 px-md-5" id='box-qr-payment'>
                            <div class='box-timeout'>
                                <p>Đang chờ thanh toán</p>
                                <span id="countdown-value">${Math.floor(timeout / 60)}:${(timeout % 60).toString().padStart(2, '0')}</span>
                            </div>
                            <div class='qr'>
                                <img src="{{ asset('assets/icons/logo-gradient.svg') }}" alt="logo trendemy" class='logo-branch'>
                                <div class='qr-container'>
                                    <img src="${qr}" alt="QR Code" class='qr-code'>
                                    <div class="corner top-left"></div>
                                    <div class="corner top-right"></div>
                                    <div class="corner bottom-left"></div>
                                    <div class="corner bottom-right"></div>
                                </div>
                                <div class="form-floating mt-3">
                                    <input type="text" id="name" placeholder=""
                                        class="form-control fw-bold" value='${name}' disabled />
                                    <label for="name">CHỦ TÀI KHOẢN</label>
                                </div>
                                <div class="form-floating mt-2">
                                    <input type="text" id="cost" placeholder=""
                                        class="form-control fw-bold" value='${amount}' disabled />
                                    <label for="cost">SỐ TIỀN</label>
                                </div>
                            </div>
                            <div class='help'>
                                <img src="{{ asset('assets/icons/question.svg') }}" alt="icon question">
                                <p>Bạn gặp khó khăn khi chuyển khoản thì hãy liên hệ với chúng tôi qua Facebook để được hỗ trợ nhé.</p>
                            </div>
                            <button class='btn btn-danger btn-dismiss text-uppercase fw-semibold mt-3'>Hủy</button>
                       </div>`,
                footer: false,
                icon: false,
            });
        }
        $document.on('click', '.modal .btn-dismiss', () => {
            clearIntervals();
        });
    </script>
@endsection
