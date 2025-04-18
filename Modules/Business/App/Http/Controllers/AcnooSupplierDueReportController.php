<?php

namespace Modules\Business\App\Http\Controllers;

use App\Models\Party;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use Modules\Business\App\Exports\ExportSupplierDue;

class AcnooSupplierDueReportController extends Controller
{
    public function index()
    {
        $total_due = Party::where('business_id', auth()->user()->business_id)->where('type','Supplier')->sum('due');
        $due_lists = Party::where('business_id', auth()->user()->business_id)->where('type','Supplier')->where('due', '>', 0)->latest()->paginate(20);
        return view('business::reports.supplier-due.due-reports', compact('due_lists','total_due'));
    }

    public function acnooFilter(Request $request)
    {
        $due_lists = Party::where('business_id', auth()->user()->business_id)->where('type','Supplier')
            ->when($request->search, function ($query) use ($request) {
                $query->where(function ($q) use ($request) {
                    $q->where('type', 'like', '%' . $request->search . '%')
                      ->orwhere('name', 'like', '%' . $request->search . '%')
                      ->orwhere('phone', 'like', '%' . $request->search . '%')
                      ->orwhere('email', 'like', '%' . $request->search . '%');
                });
            })
            ->latest()
            ->paginate($request->per_page ?? 10);

        if ($request->ajax()) {
            return response()->json([
                'data' => view('business::reports.supplier-due.datas', compact('due_lists'))->render()
            ]);
        }
        return redirect(url()->previous());
    }

    public function generatePDF(Request $request)
    {
        $due_lists = Party::where('business_id', auth()->user()->business_id)->where('type','Supplier')->latest()->get();
        $pdf = Pdf::loadView('business::reports.supplier-due.pdf', compact('due_lists'));
        return $pdf->download('supplier.due.pdf');
    }

    public function exportExcel()
    {
        return Excel::download(new ExportSupplierDue, 'supplier-due.xlsx');
    }

    public function exportCsv()
    {
        return Excel::download(new ExportSupplierDue, 'supplier-due.csv');
    }
}
