<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DebtController extends Controller
{
    private $debts = [];
    private $nextId = 1;

    public function __construct()
    {
        $this->debts = [
            [
                'id' => 1,
                'type' => 'piutang',
                'person_name' => 'PT. ABC Supplier',
                'amount' => 5000000,
                'initial_amount' => 5000000,
                'due_date' => '2024-02-15',
                'status' => 'active'
            ]
        ];
        $this->nextId = 2;
    }

    public function index()
    {
        if (!session('logged_in') || session('user_type') !== 'advance') {
            return redirect()->route('login.index')->with('error', 'Akses ditolak.');
        }

        return view('pages.debts.index', ['debts' => $this->debts]);
    }

    public function create()
    {
        if (!session('logged_in') || session('user_type') !== 'advance') {
            return redirect()->route('login.index')->with('error', 'Akses ditolak.');
        }

        return view('pages.debts.create');
    }

    public function store(Request $request)
    {
        if (!session('logged_in') || session('user_type') !== 'advance') {
            return redirect()->route('login.index')->with('error', 'Akses ditolak.');
        }

        $request->validate([
            'type' => 'required|in:hutang,piutang',
            'person_name' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
            'due_date' => 'required|date',
            'interest_rate' => 'nullable|numeric|min:0',
            'description' => 'nullable|string'
        ]);

        $debt = [
            'id' => $this->nextId++,
            'type' => $request->type,
            'person_name' => $request->person_name,
            'amount' => $request->amount,
            'initial_amount' => $request->amount,
            'due_date' => $request->due_date,
            'interest_rate' => $request->interest_rate ?? 0,
            'description' => $request->description,
            'status' => 'active'
        ];

        $this->debts[] = $debt;

        return redirect()->route('debts.index')->with('success', 'Data hutang/piutang berhasil ditambahkan!');
    }
}