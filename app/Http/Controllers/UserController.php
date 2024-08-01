<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Shop;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
  
    public function mypage()
    {
        $user = Auth::user();

        return view('users.mypage', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        $user = Auth::user();

        return view('users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $user = Auth::user();
 
        $user->name = $request->input('name') ? $request->input('name') : $user->name;
        $user->email = $request->input('email') ? $request->input('email') : $user->email;
        $user->postal_code = $request->input('postal_code') ? $request->input('postal_code') : $user->postal_code;
        $user->address = $request->input('address') ? $request->input('address') : $user->address;
        $user->phone = $request->input('phone') ? $request->input('phone') : $user->phone;
        $user->update();

        return to_route('mypage');
    }
    public function update_password(Request $request)
    {
        $validatedData = $request->validate([
            'password' => 'required|confirmed',
        ]);

        $user = Auth::user();

        if ($request->input('password') == $request->input('password_confirmation')) {
            $user->password = bcrypt($request->input('password'));
            $user->update();
        } else {
            return to_route('mypage.edit_password');
        }

        return to_route('mypage');
    }

    public function edit_password()
    {
        return view('users.edit_password');
    }
    

    public function favorite()
     {
         $user = Auth::user();
 
         $favorites = $user->favorites(Shop::class)->get();
 
         return view('users.favorite', compact('favorites'));
     }
     public function destroy(Request $request)
     {
         Auth::user()->delete();
         return redirect('/');
     }

     public function register_card(Request $request)
     {
         $user = Auth::user();
 
         $pay_jp_secret = env('PAYJP_SECRET_KEY');
         \Payjp\Payjp::setApiKey($pay_jp_secret);
 
         $card = [];
         $count = 0;
 
         if ($user->token != "") {
             $result = \Payjp\Customer::retrieve($user->token)->cards->all(array("limit"=>1))->data[0];
             $count = \Payjp\Customer::retrieve($user->token)->cards->all()->count;
 
             $card = [
                 'brand' => $result["brand"],
                 'exp_month' => $result["exp_month"],
                 'exp_year' => $result["exp_year"],
                 'last4' => $result["last4"] 
             ];
         }
 
         return view('users.register_card', compact('card', 'count'));
     }
 
     public function token(Request $request)
     {
         $pay_jp_secret = env('PAYJP_SECRET_KEY');
         \Payjp\Payjp::setApiKey($pay_jp_secret);
 
         $user = Auth::user();
         $customer = $user->token;
 
         if ($customer != "") {
             $cu = \Payjp\Customer::retrieve($customer);
             $delete_card = $cu->cards->retrieve($cu->cards->data[0]["id"]);
             $delete_card->delete();
             $cu->cards->create(array(
                 "card" => request('payjp-token')
             ));
         } else {
             $cu = \Payjp\Customer::create(array(
                 "card" => request('payjp-token')
             ));
             $user->token = $cu->id;
             $user->update();
         }
 
         return to_route('mypage');
     }

     public function subscribe(Request $request)
{
    $pay_jp_secret = env('PAYJP_SECRET_KEY');
    \Payjp\Payjp::setApiKey($pay_jp_secret);

    $user = Auth::user();
    $customer = $user->token;

    if (!$customer) {
        return redirect()->route('mypage.register_card')->withErrors('カードを登録してください。');
    }

    // メモしておいたプランIDをここに設定
    $planId = 'NAGOYAMESHI';
//確認
    $subscriptions = \Payjp\Subscription::all(array("customer" => $customer));

    foreach ($subscriptions->data as $subscription) {
        if ($subscription->plan->id == $planId) {
            return redirect()->route('mypage')->withErrors('あなたは有料会員です。');
        }
    }

    // サブスクリプションの作成
    $subscription = \Payjp\Subscription::create([
        'customer' => $customer,
        'plan' => $planId,
    ]);

    // サブスクリプションの情報をユーザーに保存（必要に応じて）
    /*$user->subscription_id = $subscription->id;
    $user->save();

    return to_route('mypage');*/
}

public function unsubscribe(Request $request)
{
    $pay_jp_secret = env('PAYJP_SECRET_KEY');
    \Payjp\Payjp::setApiKey($pay_jp_secret);

    $user = Auth::user();
    $customer = $user->token;

    if (!$customer) {
        return redirect()->route('mypage')->withErrors('あなたは有料会員ではありません。');
    }

    // 全サブスクリプションを取得してキャンセルする
    $subscriptions = \Payjp\Subscription::all(array("customer" => $customer));

    foreach ($subscriptions->data as $subscription) {
        $subscription = \Payjp\Subscription::retrieve($subscription->id);
        $subscription->cancel();
    }
    Log::info('トライ前');
    try {
        $cu = \Payjp\Customer::retrieve($customer);
        $cards = $cu->cards->all();

        foreach ($cards->data as $card) {
            $cu->cards->retrieve($card->id)->delete();
        }

        // Set token to empty as the customer no longer has a card
        $user->token = '';
        $user->update();
        Log::info('トライ最後');
    } catch (\Exception $e) {
        Log::info('キャッチ前');
        return redirect()->route('mypage')->withErrors('カード情報の削除中にエラーが発生しました。');
    }
    Log::info('キャッチ最後');
    return redirect()->route('mypage')->with('message', '有料会員を退会し、カード情報を削除しました。');
}
}
