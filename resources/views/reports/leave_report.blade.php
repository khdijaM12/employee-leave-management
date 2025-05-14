<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>تقرير الإجازات</title>
    <style>
        @font-face {
            font-family: 'DejaVu Sans';
            font-style: normal;
            font-weight: normal;
            src: url('{{ storage_path('fonts/DejaVuSans.ttf') }}') format('truetype');
        }
        body {
            font-family: 'DejaVu Sans', sans-serif;
            direction: rtl;
            text-align: right;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <h1 style="text-align: center;">تقرير الإجازات</h1>
    <table>
        <thead>
            <tr>
                <th>اسم الموظف</th>
                <th>رقم الموظف</th>
                <th>رقم الجوال</th>
                <th>عدد طلبات الإجازة</th>
                <th>تاريخ آخر طلب</th>
                <th>نوع آخر إجازة</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($reportData as $data)
                <tr>
                    <td>{{ $data['employee_name'] }}</td>
                    <td>{{ $data['employee_number'] }}</td>
                    <td>{{ $data['mobile_number'] }}</td>
                    <td>{{ $data['leave_requests_count'] }}</td>
                    <td>{{ $data['last_leave_request_date'] }}</td>
                    <td>{{ $data['last_leave_type'] }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>