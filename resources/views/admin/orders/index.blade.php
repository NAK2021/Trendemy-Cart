@extends('admin.master')

@section('title', 'Hóa Đơn')
@php
    use App\Helpers\NumberFormat;
    use Carbon\Carbon;
    use App\Enums\OrderState;
    use App\Enums\CouponType;
@endphp
@section('main')
    <div class="row">
        <div class="col-md-12">
            <div class="card table-responsive text-center p-3">
                <h3 class="text-uppercase fw-bold m-3">Danh Sách Hóa Đơn</h3>
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Tên khách hàng</th>
                            <th scope="col">Giảm giá</th>
                            <th scope="col">Tổng</th>
                            <th scope="col">Ưu đãi</th>
                            <th scope="col">Thanh toán qua</th>
                            <th scope="col">Trạng thái</th>
                            <th scope="col">Tạo lúc</th>
                            <th scope="col"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($orders ?? [] as $order)
                            <tr>
                                <th scope="row">{{ $loop->iteration }}</th>
                                <td>{{ $order->user->name ?? '' }}</td>
                                <td>- {{ NumberFormat::VND($order->discount) }}</td>
                                <td>{{ NumberFormat::VND($order->total) }}</td>
                                <td>
                                    @php
                                        $promotions = json_decode($order->promotion, true);
                                    @endphp
                                    @if (is_array($promotions))
                                        @foreach ($promotions as $prom)
                                            @if ($prom['type'] === CouponType::FIXED)
                                                - {{ NumberFormat::VND($prom['value']) }} <br />
                                            @elseif ($prom['type'] === CouponType::PERCENT)
                                                - {{ $prom['value'] }}% <br />
                                            @endif
                                        @endforeach
                                    @endif
                                    {{-- {{ $order->promotion }} --}}
                                </td>
                                <td>
                                    @foreach ($order->transactions as $transaction)
                                        {{ $transaction->payment_method }} <br />
                                    @endforeach
                                </td>
                                <td>
                                    <span
                                        @if ($order->state === OrderState::PENDING) class="badge bg-secondary"
                                        @elseif ($order->state === OrderState::PAID) class="badge bg-success"
                                        @elseif ($order->state === OrderState::FAILED) class="badge bg-danger" @endif>
                                        {{ $order->state }}
                                    </span>

                                </td>
                                <td>{{ Carbon::parse($order->created_at)->format('H:i:s, d-m-Y') }}</td>
                                <td>
                                    <a href="{{ route('admin.orders.show', $order->id) }}">
                                        <i class='bx bxs-chevron-right'></i>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="12">KHÔNG CÓ DỮ LIỆU</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="d-flex justify-content-center">{{ $orders->links('pagination::bootstrap-4') }}</div>
            </div>
        </div>
    </div>
@endsection
