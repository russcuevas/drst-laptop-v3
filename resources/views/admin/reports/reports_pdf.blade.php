<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reports</title>
        <style>
        body {
            font-family: Arial, sans-serif;
        }

        h1 {
            font-size: 16px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
            font-size: 7px;
        }

        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>

    <h1>Reports</h1>

    <table>
        <thead>
            <tr>
                <th>Reference Number</th>
                <th>Invoice Number</th>
                <th>Customer Name</th>
                <th>Email</th>
                <th>Products Ordered</th>
                <th>Total Amount</th>
                <th>Payment Method</th>
                <th>Status</th>
                <th>Date Ordered</th>
                <th>Received Date</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($reports as $report)
                <tr>
                    <td>{{ $report->reference_number }}</td>
                    <td>{{ $report->invoice_number }}</td>
                    <td>{{ $report->fullname }}</td>
                    <td>{{ $report->email }}</td>
                    <td>{{ $report->products_ordered }}</td>
                    <td>{{ $report->total_amount }}</td>
                    <td>{{ $report->payment_method }}</td>
                    <td>{{ $report->status }}</td>
                    <td>{{ $report->ordered_date }}</td>
                    <td>{{ $report->receiving_date }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

</body>
</html>
