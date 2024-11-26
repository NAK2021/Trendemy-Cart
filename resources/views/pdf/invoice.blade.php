<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Hóa Đơn Điện Tử</title>
    <style>
        body {
            font-family: DejaVu Sans;
        }

        .text-center {
            text-align: center;
        }

        h1 {
            text-transform: uppercase;
            font-size: 28px;
        }

        .courses {
            width: 100%;
            text-align: center;
            border-collapse: collapse;
        }

        .courses th {
            font-size: 20px;
            text-transform: uppercase;
        }

        .courses .name {
            font-size: 24px;
            font-weight: normal;
        }

        .courses .lecturer {
            font-size: 20px;
            color: #6D6B6B;
        }

        .courses .price {
            font-size: 20px;
        }

        .courses th,
        .courses td {
            padding: 15px;
            border-bottom: 1px solid #ddd;
        }

        .summary {
            width: 45%;
            margin-left: auto;
            margin-top: 20px;
        }

        .summary td:last-child {
            text-align: right;
        }

        .summary td {
            border: none;
            padding: 5px 0;
        }

        .total-row td {
            font-weight: bold;
        }

        .space {
            border-top: 1.5px solid #333;
            margin: 0;
        }

        .customer {
            width: 45%;
            margin-left: auto;
            margin-top: 20px;
            text-align: center;
        }

        .customer h3 {
            font-size: 25px;
            margin-bottom: 5px;
        }

        .customer p {
            margin: 0;
            margin-bottom: 10px;
        }

        .customer p,
        .customer span {
            font-size: 20px;
        }
    </style>
</head>

<body>
    <div class="text-center">
        <img src="{{ asset('assets/icons/logo-gradient.svg') }}" alt="Logo Trendemy">
        <h1>Hóa Đơn Điện Tử</h1>
    </div>
    <div>
        <p>
            <span>Mã hóa đơn: </span>
            <span>{{ $order['code'] }}</span>
        </p>
        <p>
            <span>Ngày tạo: </span>
            <span>{{ $order['created_at'] }}</span>
        </p>
    </div>
    <table class="courses">
        <tr>
            <th>Sản phẩm</th>
            <th>Giá</th>
        </tr>
        @foreach ($order['courses'] as $course)
            <tr>
                <td>
                    <span class="name">{{ $course['course_name'] }}</span>
                    <br />
                    <span class="lecturer">{{ $course['lecturer'] ?? '' }}</span>
                </td>
                <td>
                    <span class="price">{{ $course['cost'] }}</span>
                </td>
            </tr>
        @endforeach
    </table>
    <table class="summary">
        <tr>
            <td>Giá niêm yết:</td>
            <td>{{ $order['base'] }}</td>
        </tr>
        <tr>
            <td>Giảm giá:</td>
            <td>{{ $order['discount'] }}</td>
        </tr>
        <tr>
            <td colspan="2">
                <p class="space"></p>
            </td>
        </tr>
        <tr class="total-row">
            <td>Tổng:</td>
            <td>{{ $order['total'] }}</td>
        </tr>
    </table>
    <table class="customer">
        <tr>
            <td>
                <h3>Cảm ơn</h3>
                <p>Tên khách hàng</p>
                <p>{{ $order['customer'] }}</p>
            </td>
        </tr>

    </table>
</body>

</html>
