<?php

namespace App\Http\Controllers\Api;

use Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HyperController extends MasterController
{
    public function hyper(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'amount' => 'required',
        ]);

        if ($validator->passes()) {


            $amount = $request['amount'];
            $currency = $request['currency'];
            $payment_type = $request['payment_type'];

            $url = "https://oppwa.com/v1/checkouts";
            $data = "entityId=8acda4ce6ade5ae2016af848479b648f" .
                "&amount=$amount" .
                "&currency=SAR" .
                "&paymentType=DB" .
                "&notificationUrl=http://www.example.com/notify";

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Authorization:Bearer OGFjZGE0Yzc2YWRlNGE0NjAxNmIwMzE5ZmUxYzc1YTB8bTN0WEphMnlOSA=='));
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);// this should be set to true in production
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $responseData = curl_exec($ch);
            if (curl_errno($ch)) {
                return curl_error($ch);
            }
            curl_close($ch);
            return $responseData;
        } else {
            return response()->json(['value' => false, 'msg' => $validator->errors()->first()]);
        }


    }

}