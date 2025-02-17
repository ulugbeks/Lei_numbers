<table class="table">
    <thead>
        <tr>
            <th>ID</th>
            <th>Full Name</th>
            <th>Company</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Plan</th>
            <th>Price</th>
            <th>Payment Status</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach($orders as $order)
        <tr>
            <td>{{ $order->id }}</td>
            <td>{{ $order->full_name }}</td>
            <td>{{ $order->company_name }}</td>
            <td>{{ $order->email }}</td>
            <td>{{ $order->phone }}</td>
            <td>{{ $order->plan }}</td>
            <td>${{ $order->total_price }}</td>
            <td>
                @if($order->payment_status === 'paid')
                    <span class="badge bg-success">Paid</span>
                @else
                    <span class="badge bg-danger">Not Paid</span>
                @endif
            </td>
            <td>
                <a href="{{ route('order.show', ['order' => $order->id]) }}" class="btn btn-primary">View</a>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
