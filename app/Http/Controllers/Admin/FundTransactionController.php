<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FundTransaction;
use Illuminate\Http\Request;

class FundTransactionController extends Controller
{
    public function index()
    {
        $transactions = FundTransaction::query()
            ->orderByDesc('date')
            ->orderByDesc('id')
            ->get();

        return view('admin.funds.index', [
            'transactions' => $transactions,
            'total'        => FundTransaction::totalBalance(),
            'additions'    => FundTransaction::additions()->sum('amount'),
            'deductions'   => FundTransaction::deductions()->sum('amount'),
            'breakdown'    => FundTransaction::breakdownByCategory(),
        ]);
    }

    public function create()
    {
        return view('admin.funds.form', [
            'transaction' => new FundTransaction(['type' => 'addition', 'category' => 'General Fund', 'date' => now()]),
        ]);
    }

    public function store(Request $request)
    {
        FundTransaction::create($this->validated($request) + ['created_by' => $request->user()->id]);

        return redirect()->route('admin.funds.index')->with('status', 'Transaction recorded.');
    }

    public function edit(FundTransaction $fund)
    {
        return view('admin.funds.form', ['transaction' => $fund]);
    }

    public function update(Request $request, FundTransaction $fund)
    {
        $fund->update($this->validated($request));

        return redirect()->route('admin.funds.index')->with('status', 'Transaction updated.');
    }

    public function destroy(FundTransaction $fund)
    {
        $fund->delete();

        return redirect()->route('admin.funds.index')->with('status', 'Transaction deleted.');
    }

    protected function validated(Request $request): array
    {
        return $request->validate([
            'type'     => ['required', 'in:addition,deduction'],
            'category' => ['required', 'string', 'max:120'],
            'title'    => ['required', 'string', 'max:200'],
            'amount'   => ['required', 'numeric', 'min:0.01'],
            'date'     => ['required', 'date'],
            'notes'    => ['nullable', 'string', 'max:600'],
        ]);
    }
}
