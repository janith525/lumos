<?php

namespace App\Http\Controllers;

use App\Models\Quote;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Yajra\DataTables\Facades\DataTables;

class AdminQuotesController extends Controller
{
    public function index(Request $request): View|JsonResponse
    {
        if ($request->ajax()) {
            $query = Quote::query()->latest();

            return DataTables::of($query)
                ->addColumn('action', function ($quote) {
                    $productTitles = [];
                    if (!empty($quote->products)) {
                        // Support numeric ID arrays or service names
                        $ids = array_filter($quote->products, 'is_numeric');
                        $strings = array_diff($quote->products, $ids);
                        
                        $productTitles = \App\Models\Product::whereIn('id', $ids)->pluck('name')->toArray();
                        $productTitles = array_merge($productTitles, $strings);
                    }

                    $quoteData = [
                        'id' => $quote->id,
                        'name' => $quote->name,
                        'email' => $quote->email,
                        'phone' => $quote->phone ?? '-',
                        'message' => $quote->message ?? '-',
                        'product_titles' => $productTitles,
                        'created_at' => $quote->created_at->format('Y-m-d H:i:s'),
                    ];

                    $viewBtn = '<button type="button" class="btn btn-outline-primary btn-sm px-3 py-1.5 me-2" style="border-radius: 8px; font-size: 12px; border: 1px solid rgba(59,130,246,0.3); color: #3b82f6; background: transparent;" onclick="showQuoteDetails('.htmlspecialchars(json_encode($quoteData), ENT_QUOTES, 'UTF-8').')">View</button>';

                    $deleteBtn = '<button type="button" class="btn btn-outline-danger btn-sm px-3 py-1.5" style="border-radius: 8px; font-size: 12px; border: 1px solid rgba(231,76,60,0.3); color: #e74c3c; background: transparent;" onclick="confirmDelete('.$quote->id.', \''.addslashes($quote->name).'\')">Delete</button>'
                        .'<form id="delete-form-'.$quote->id.'" action="'.route('admin.quotes.delete', $quote->id).'" method="POST" style="display:none;">'
                        .csrf_field()
                        .method_field('DELETE')
                        .'</form>';

                    return $viewBtn . $deleteBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('backend.quotes.index', [
            'title' => 'Quotes Management | Lumos',
        ]);
    }

    public function destroy(int $id): RedirectResponse
    {
        $quote = Quote::findOrFail($id);
        $quote->delete();

        return redirect()->route('admin.quotes')->with('success', 'Quote request deleted successfully!');
    }
}
