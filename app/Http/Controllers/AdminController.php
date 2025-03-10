<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contact;

class AdminController extends Controller
{
    public function dashboard()
    {
        return view('admin.dashboard');
    }

    public function contacts()
    {
        return view('admin.contacts');
    }

    public function orders()
    {
        $orders = Order::latest()->get();
        return view('admin.orders.index', compact('orders'));
    }

    public function updatePaymentStatus($id)
    {
        $order = Order::findOrFail($id);
        $order->payment_status = 'paid';
        $order->save();

        return back()->with('success', 'Payment status updated!');
    }

    public function paymentReport()
    {
        $payments = Contact::where('payment_status', 'paid')
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        // Статистика
        $totalRevenue = Contact::where('payment_status', 'paid')->sum('amount');
        $totalPayments = Contact::where('payment_status', 'paid')->count();
        $averagePayment = $totalPayments > 0 ? $totalRevenue / $totalPayments : 0;

        // Самый популярный план
        $popularPlan = Contact::where('payment_status', 'paid')
            ->groupBy('selected_plan')
            ->select('selected_plan', \DB::raw('count(*) as total'))
            ->orderBy('total', 'desc')
            ->first();

        return view('admin.payment-report', compact(
            'payments',
            'totalRevenue',
            'totalPayments',
            'averagePayment',
            'popularPlan'
        ));
    }

    public function exportPayments()
    {
        $payments = Contact::where('payment_status', 'paid')
            ->orderBy('created_at', 'desc')
            ->get();

        $excel = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $excel->getActiveSheet();

        // Заголовки
        $sheet->setCellValue('A1', 'Date');
        $sheet->setCellValue('B1', 'Legal Entity');
        $sheet->setCellValue('C1', 'Email');
        $sheet->setCellValue('D1', 'Plan');
        $sheet->setCellValue('E1', 'Service');
        $sheet->setCellValue('F1', 'Amount');
        $sheet->setCellValue('G1', 'Status');

        // Данные
        $row = 2;
        foreach ($payments as $payment) {
            $sheet->setCellValue('A' . $row, $payment->created_at->format('Y-m-d H:i'));
            $sheet->setCellValue('B' . $row, $payment->legal_entity_name);
            $sheet->setCellValue('C' . $row, $payment->email);
            $sheet->setCellValue('D' . $row, $payment->selected_plan);
            $sheet->setCellValue('E' . $row, $payment->service_type);
            $sheet->setCellValue('F' . $row, $payment->amount);
            $sheet->setCellValue('G' . $row, $payment->payment_status);
            $row++;
        }

        // Стили
        $sheet->getStyle('A1:G1')->getFont()->setBold(true);
        foreach(range('A','G') as $column) {
            $sheet->getColumnDimension($column)->setAutoSize(true);
        }

        // Скачивание
        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($excel);
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="payments_report.xlsx"');
        header('Cache-Control: max-age=0');
        $writer->save('php://output');
    }
}
