@extends('client.main')

@section('title', 'Thanh Toán')

@section('styles')
    <style></style>
@endsection
@section('main')
    <div class="row">
        @if ($result)
            <div>
                <button class="btn-back mt-3">
                    <i class="fa-solid fa-arrow-left"></i>
                    &nbsp;Quay lại
                </button>
            </div>
            <div class="col-md-3 my-3"></div>
            <div class="col-md-6 my-3">
                <ul class="progressbar">
                    <li class="active">Phương thức thanh toán</li>
                    <li class="active">Hoàn tất mua hàng</li>
                </ul>
            </div>
            <div class="col-md-3 my-3"></div>
            <div class="col-md-2"></div>
            <div class="col-md-8 mt-5">
                <div class="alert alert-success mb-3">
                    <svg width="64" height="63" viewBox="0 0 64 63" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M58.25 29.0849V31.4999C58.2468 37.1605 56.4138 42.6684 53.0245 47.2022C49.6352 51.736 44.8711 55.0526 39.4428 56.6576C34.0145 58.2626 28.2128 58.0699 22.903 56.1082C17.5932 54.1465 13.0597 50.5209 9.97877 45.7722C6.89782 41.0235 5.43445 35.4061 5.8069 29.7577C6.17935 24.1094 8.36767 18.7327 12.0455 14.4297C15.7233 10.1267 20.6936 7.12777 26.215 5.88027C31.7364 4.63278 37.5132 5.20352 42.6838 7.50739"
                            stroke="#3CB43A" stroke-width="8" stroke-linecap="round" stroke-linejoin="round" />
                        <path d="M58.25 10.5L32 36.7763L24.125 28.9013" stroke="#3CB43A" stroke-width="8"
                            stroke-linecap="round" stroke-linejoin="round" />
                    </svg>

                    <h3 class="alert-title mt-3">GIAO DỊCH THÀNH CÔNG!</h3>
                    <p>Cảm ơn bạn đã tham gia khóa học của Trendemy!</p>
                    <p>Chúng tôi hy vọng bạn sẽ có những trải nghiệm học tập tuyệt vời. Chúc bạn thành công!</p>
                </div>
            </div>
            <div class="col-md-2"></div>
            <div class="col-md-2"></div>
            <div class="col-md-8 d-flex align-items-center justify-content-around mt-3 gap-3">
                <button type="button" class="btn btn-info text-white fw-semibold py-2 px-5" id="btn-home">
                    Quay về trang chủ
                </button>
                <a href="{{ route('download-invoice') }}" class="btn btn-success text-white fw-semibold py-2 px-5">
                    Xem đơn hàng
                </a>
            </div>
            <div class="col-md-2"></div>
        @else
            <div class="col-md-12 mt-5 d-flex flex-column align-items-center">
                <svg width="126" height="119" viewBox="0 0 126 119" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M62.9998 108.419C91.6495 108.419 114.875 86.355 114.875 59.1377C114.875 31.9204 91.6495 9.85645 62.9998 9.85645C34.35 9.85645 11.1248 31.9204 11.1248 59.1377C11.1248 86.355 34.35 108.419 62.9998 108.419Z"
                        stroke="#EC1F27" stroke-width="9.3375" stroke-linecap="round" stroke-linejoin="round" />
                    <path d="M78.5625 44.353L47.4375 73.9218" stroke="#EC1F27" stroke-width="9.3375" stroke-linecap="round"
                        stroke-linejoin="round" />
                    <path d="M47.4375 44.353L78.5625 73.9218" stroke="#EC1F27" stroke-width="9.3375" stroke-linecap="round"
                        stroke-linejoin="round" />
                </svg>
                <p class="fw-semibold fs-5 mt-2">Thanh toán thất bại</p>
            </div>
            <div class="col-md-2"></div>

            <div class="col-md-8 mt-2">
                <div class="alert alert-danger mb-3">
                    <p>
                        Giao dịch không thành công vì bị gián đoạn. Qúy khách vui lòng
                        kiểm tra
                    </p>
                    <p>
                        giao dịch. Mọi thắc mắc xin liên hệ qua Hotline
                        <a href="#">1234567</a> để được hỗ trợ.
                    </p>
                </div>
            </div>
            <div class="col-md-2"></div>
            <div class="col-md-2"></div>

            <div class="col-md-8 d-flex align-items-center justify-content-around mt-3 gap-3">
                <button type="button" class="btn btn-info fw-semibold text-white py-2 px-5" id="btn-home">
                    Quay về trang chủ
                </button>
                <button type="button" class="btn btn-danger fw-semibold py-2 px-5" id="btn-rePayment">
                    Thanh toán lại
                </button>
            </div>
            <div class="col-md-2"></div>
        @endif
    </div>
@endsection
@section('scripts')
    <script>
        $document.on('click', '#btn-home', function() {
            window.location.href = '/';
        });
        $document.on('click', '#btn-rePayment', function() {
            window.location.href = '/thanh-toan';
        });
    </script>
@endsection
