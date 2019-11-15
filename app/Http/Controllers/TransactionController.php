<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\TeddyBear;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    public function teddyBears()
    {
        $teddy_bears = TeddyBear::all();
        $roles = Role::all()->where('id','<=',Auth::user()->role_id);

        return view('transactions.teddy_bears',[
            'teddy_bears' => $teddy_bears,
            'roles' => $roles
        ]);
    }

    public function teddyBear(TeddyBear $teddy_bear)
    {
        $teddy = $teddy_bear;

        $transactions = $teddy->transactions;

        return view('transactions.teddy_bear',[
            'teddy' => $teddy,
            'transactions' => $transactions
        ]);
    }

    public function newTeddy(Request $request)
    {
        $name = $request->input('name');
        $description = $request->input('description');
        $role = $request->input('role');
        $balance = $request->input('balance');

        $teddy = new TeddyBear();
        $teddy->name = $name;
        $teddy->description = $description;
        $teddy->role_id = $role;
        $teddy->balance = $balance;
        $teddy->save();

        $transaction = new Transaction();
        $transaction->user_id = Auth::user()->id;
        $transaction->for = "Kezdő egyenleg";
        $transaction->in = $balance>0;
        $transaction->teddy_bear_id = $teddy->id;
        $transaction->amount = abs($balance);
        $transaction->save();

        return redirect()->back();
    }

    public function addBalance(Request $request, TeddyBear $teddy_bear)
    {
        if(Auth::user()->role_id<$teddy_bear->role_id)
        {
            abort(401);
        }

        $transaction = new Transaction();
        $transaction->amount = abs($request->input('amount'));
        $transaction->in = $request->input('amount')>0;
        $transaction->for = $request->input('amount')>0 ? "Bevétel" : "Kiadás";
        $transaction->teddy_bear_id = $teddy_bear->id;
        $transaction->user_id = Auth::user()->id;
        $transaction->save();

        return redirect()->back();
    }
}
