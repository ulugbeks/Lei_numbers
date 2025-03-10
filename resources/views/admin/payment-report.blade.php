@extends('layouts.admin')

@section('content')
<div class="container" style="max-width: 100%;">
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Payment Report</h5>
                    <div>
                        <a href="{{ route('admin.payments.export') }}" class="btn btn-success">
                            <i class="fas fa-download"></i> Export to Excel
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <!-- Сводная статистика -->
                    <div class="row mb-4">
                        <div class="col-md-3">
                            <div class="card bg-primary text-white">
                                <div class="card-body">
                                    <h6>Total Revenue</h6>
                                    <h3>${{ number_format($totalRevenue, 2) }}</h3>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card bg-success text-white">
                                <div class="card-body">
                                    <h6>Total Payments</h6>
                                    <h3>{{ $totalPayments }}</h3>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card bg-info text-white">
                                <div class="card-body">
                                    <h6>Average Payment</h6>
                                    <h3>${{ number_format($averagePayment, 2) }}</h3>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card bg-warning text-white">
                                <div class="card-body">
                                    <h6>Most Popular Plan</h6>
                                    <h3>{{ $popularPlan }}</h3>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Таблица платежей -->
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Legal Entity</th>
                                    <th>Email</th>
                                    <th>Plan</th>
                                    <th>Service</th>
                                    <th>Amount</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($payments as $payment)
                                <tr>
                                    <td>{{ $payment->created_at->format('Y-m-d H:i') }}</td>
                                    <td>{{ $payment->legal_entity_name }}</td>
                                    <td>{{ $payment->email }}</td>
                                    <td>
                                        <span class="badge bg-primary">{{ $payment->selected_plan }}</span>
                                    </td>
                                    <td>
                                        @if($payment->service_type == 'complete')
                                            <span class="badge bg-success">Complete</span>
                                        @else
                                            <span class="badge bg-secondary">Standard</span>
                                        @endif
                                    </td>
                                    <td>${{ number_format($payment->amount, 2) }}</td>
                                    <td>
                                        @if($payment->payment_status == 'paid')
                                            <span class="badge bg-success">Paid</span>
                                        @else
                                            <span class="badge bg-warning">{{ $payment->payment_status }}</span>
                                        @endif
                                    </td>
                                    <td>
                                        <button class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#paymentDetails{{ $payment->id }}">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                    </td>
                                </tr>

                                <!-- Модальное окно с деталями -->
                                <div class="modal fade" id="paymentDetails{{ $payment->id }}" tabindex="-1">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Payment Details</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                            <div class="modal-body">
                                                <dl class="row">
                                                    <dt class="col-sm-4">Legal Entity:</dt>
                                                    <dd class="col-sm-8">{{ $payment->legal_entity_name }}</dd>

                                                    <dt class="col-sm-4">Registration ID:</dt>
                                                    <dd class="col-sm-8">{{ $payment->registration_id }}</dd>

                                                    <dt class="col-sm-4">Email:</dt>
                                                    <dd class="col-sm-8">{{ $payment->email }}</dd>

                                                    <dt class="col-sm-4">Phone:</dt>
                                                    <dd class="col-sm-8">{{ $payment->phone }}</dd>

                                                    <dt class="col-sm-4">Address:</dt>
                                                    <dd class="col-sm-8">
                                                        {{ $payment->address }}, {{ $payment->city }}, {{ $payment->zip_code }}
                                                    </dd>

                                                    <dt class="col-sm-4">Plan:</dt>
                                                    <dd class="col-sm-8">{{ $payment->selected_plan }}</dd>

                                                    <dt class="col-sm-4">Service:</dt>
                                                    <dd class="col-sm-8">{{ ucfirst($payment->service_type) }}</dd>

                                                    <dt class="col-sm-4">Amount:</dt>
                                                    <dd class="col-sm-8">${{ number_format($payment->amount, 2) }}</dd>

                                                    <dt class="col-sm-4">Status:</dt>
                                                    <dd class="col-sm-8">{{ ucfirst($payment->payment_status) }}</dd>

                                                    <dt class="col-sm-4">Payment Date:</dt>
                                                    <dd class="col-sm-8">{{ $payment->created_at->format('Y-m-d H:i:s') }}</dd>
                                                </dl>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Пагинация -->
                    <div class="mt-4">
                        {{ $payments->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection