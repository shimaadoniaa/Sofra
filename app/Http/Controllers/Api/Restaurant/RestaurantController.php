<?php

namespace App\Http\Controllers\Api\Restaurant;

use App\Http\Controllers\Controller;

use App\Http\ResponseTrait;
use App\Model\Client;
use App\Model\Distriction;
use App\Model\Offer;
use App\Model\Order;
use App\Model\Paid;
use App\Model\Product;
use App\Model\Restaurant;
use App\Model\Token;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;




class RestaurantController extends Controller
{
    use ResponseTrait;


//==============Register=============================

    public function register(Request $request){

        $validator=Validator::make($request->all(),[

            'email'=>'required|unique:restaurants',
            'restaurant_name'=>'required',
            'password'=>'required|confirmed',
            'phone'=>'required',
            'distriction_id'=>'required',
            'minimum_order'=>'required',
            'whatsApp'=>'required',
            'img'=>'required',
            'status'=>'required',
            'delivery_fees'=>'required',


        ]);
        if ($validator->fails()){

            return $this->responseJson('0',$validator->errors()->first(),$validator->errors());
        }

        $request->merge(['password'=>bcrypt($request->password)]);
        $restaurant=Restaurant::create($request->all());
        $restaurant->api_token=Str::random('60');
        $restaurant->save();

        if ($request->has('distriction_id')){
          $distriction=Distriction::find($request->distriction_id);

           // $restaurant->city()->update([$distriction->city_id]);
        }
        return $this->responseJson('1','done',$restaurant);

    }
//----------------End Register-------------------

//------------Log in--------------------

    public function login(Request $request){

        $validator=Validator::make($request->all(),[

            'email'=>'required',

            'password'=>'required',


        ]);
        if ($validator->fails()){

            return $this->responseJson('0',$validator->errors()->first(),$validator->errors());
        }
        $restaurant=Restaurant::where('email',$request->email)->first();
        if($restaurant){

            if( Hash::check($request->password,$restaurant->password)) {

                return $this->responseJson('1','Done',['api_token'=>$restaurant->api_token]);

            }

            return $this->responseJson('0','error','error');


        }
        return $this->responseJson('0',$validator->errors()->first(),null);

    }
//-------------End login--------------------


//------------ Reset password -------------------

    public function reset(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'email' => 'required'
        ]);

        if ($validator->fails()) {
            return $this->responseJson('0', $validator->errors()->first(), $validator->errors());
        }
        // find  -  get -- all - paginate
        // create - update - firstOrCreate
        $restaurants = Restaurant::where('email', $request->email)->first();
        if ($restaurants)

        {
            $code = Str::random(8);
            $restaurants->pin_code = $code;
            $restaurants->save();


            # send sms

            // smsMisr($request->phone,'your reset code is:'.$code);----------->>>>>>>


            # Send E-mail

            mail::to($restaurants->email)
                // ->cc()
                ->bcc('examplemail.com')
                ->send(new resetpassword($code));


            return $this->responseJson('1', 'برجاء فحص الهاتف', [
                'pin_code' => $code,
                'mail_fails' => mail_fails()

            ]);
        } else {

            return $this->responseJson('0', 'يوجد خطا', 'null');
        }

        return $this->responseJson('0', 'لا يوجد حساب مرتبط بهذا الهاتف', 'null');

    }
// ----------------End ResetPassword--------------


// ---------------New Pssword Restaurant----------------

    public function newpassword(Request $request){

        $validator = validator::make($request->all(), [
            'pin_code' => 'required',
            'email'    => 'required',
            'password' => 'required|confirmed',
        ]);

        if ($validator->fails()){
            return $this->responseJson('0',$validator->errors()->first(), $validator->errors());
        }

        $restaurants = Restaurant::where('pin_code',$request->pin_code)->where('pin_code','!=','0')->where('email',$request->email)->first();
        if($restaurants)
        {
            $restaurants->password = bcrypt($request->password);
            $restaurants->password = null;
            $save  = $restaurants->save();

            if ($save) {

                return $this->responseJson('0','تم تغير كلمة السر بنجاح', 'null' );

            }

            else{
                return $this->responseJson('0','حدث خطا حاول مرة اخري' ,'null' );
            }
        }


        else{

            return $this->responseJson('0','هذا الكود غير صالح' ,'null' );
        }

    }


// ---------------End NewPassword-----------




//----------------edit Order---------------------------

    public function editOrder(Request $request){
      $order=$request->user()->product()->find($request->order_id);
       if(!$order)

      return $this->responseJson('0','error','error');

        $order->update($request->all());
        $order->save();
        return $this->responseJson('1','Done',$order);

    }

//-------------------add-Order--------------------------------

    public function order(Request $request){
        $validator=validator::make($request->all(),[
            'img'=>'required|image|mimes:jpeg,png,jpg,gif,svg',
            'name'=>'required',
            'details'=>'required',
            'price'=>'required',
            'price_in_offer'=>'required',
            'duration_order'=>'required',
        ]);
     $order=Product::create($request->all());

        if ($request->hasFile('img')) {

            $img=$request->file('img');
            $imgEx=$img->getClientOriginalExtension();
            $imgName=$img->getClientOriginalName();
            $path=$imgName.$imgEx;
            $request->file('img')->storeAs('public/img',$path);

        }
        $order->img="";
        $order->save();
     return $this->responseJson('1','Done',$order);
    }


//-------------------edit-Profile--------------------------------
    public function editProfile(Request $request){

        $validator=validator::make($request->all(),[
            'email'=>'required|unique:restaurants',
            'restaurant_name'=>'required',
            'password'=>'required|confirmed',
            'phone'=>'required',
            'distriction_id'=>'required',
            'minimum_order'=>'required',
            'whatsApp'=>'required',
            'img'=>'required',
            'status'=>'required',
            'delivery_fees'=>'required',
        ]);
        if ($validator->fails()) {

          return $this->responseJson('0',$validator->errors()->first(),$validator->errors());
        }
        $profile=$request->user();
        $profile->update($request->only('email', 'restaurant_name','phone','password','distriction_id','minimum_order','delivery_fees','whatsApp','status' ));

        if($request->hasFile('img')) {

            $img=$request->file('img');
            $imgEx=$img->getClientOriginalExtension();
            $imgName=$img->getClientOriginalName();
            $path=$imgName.$imgEx;
            $request->file('img')->storeAs('public/img',$path);
            $profile->img = "public/img".$path;
        }
        $profile->save();

        return $this->responseJson('1','Done',$profile);


    }
   //----------------------delete - Order----------------------
    public function deleteOrder(Request $request)
    {

        $product = $request->user()->product()->find($request->id);
        if ($product != null) {
            $product->delete();
            return $this->responseJson(1, 'deleted');
        }
        return $this->responseJson('0', 'error','null');
    }

//----------------------------add Offer--------------------------------

    public function addOffer(Request $request){
  $validator=validator($request->all([
    'name'=>'required',
    'img'=>'required',
    'content'=>'required',
    'timestamps'=>'required',

  ]));
  if($validator->fails()){
    return $this->responseJson('0',$validator->errors()->first(),$validator->errors());
  }
$offers=$request->user()->offers()->create($request->all());

  if ($request->hasFile('img')){

      $img=$request->file('img');
      $imgName=$img->getClientOriginalName();
      $imgEx=$img->getClientOriginalExtension();
      $path=$imgName.$imgEx;
      $request->file('img')->storeAs('public/img',$path);
      $offers->img='public/img'.$path;
  }
           $offers->save();

        return $this->responseJson('1','تم ',$offers);

    }
//--------------------edit Offer------------------------

    public function editOffer(Request $request){

      $offer=$request->user()->offers()->find($request->offer_id);
        if (!$offer)
        {
            // error

           return $this->responseJson('0','No Offer','No Offer');
        }
        $offer->update($request->only('name','content'));
        // upload image
       if ($request->hasFile('img')) {

         $img=$request->file('img');
         $imgEx=$img->getClientOriginalExtension();
         $imgName=$img->getClientOriginalName();
         $path = $imgName.$imgEx;
         $request->file('img')->storeAs('public/img',$path);
           $offer->img ='public/img'.$path;
       }

          $offer->save();

        //return success
        return $this->responseJson('1','done',$offer);

    }
   //-------------------delete-Offer-------------------
    public function deleteOffer(Request $request)
    {

           $offer = $request->user()->offers()->find($request->id);
        if ($offer != null) {
            $offer->delete();
            return $this->responseJson(1, 'success');
        }
        return $this->responseJson(0, 'error');
        }


  //----------------commission-------------------------

    public function commission(Request $request){

        $price=Order::where('restaurant_id',$request->restaurant_id)->sum('price');
        $commission=Order::where('restaurant_id',$request->restaurant_id)->sum('commission');
        $amount=Paid::where('restaurant_id',$request->restaurant_id)->sum('amount');

        $rest= $commission-$amount;

        return $this->responseJson('1','done',[$price,$commission,$amount,$rest]);
    }

    //--------------------get Orders--------------------------------

    public function orders(Request $request){
        $orders=$request->user()->order()->where(function ($orders) use($request){

         if ($request->status == 'pending'){

          $orders->where('status'=='pending');
         }

            if ($request->status == 'current'){

                $orders->whereIn('status'=='accepted');
            }
            if ($request->status == 'current'){

                $orders->whereNotIn('status',['accepted','pending']);
            }

        })->latest()->paginate(6);

        return $this->responseJson('1','Done',$orders);
    }


    //----------------------Accept Order--------------------------
    public function acceptOrder(Request $request)
    {

        $order = $request->user()->order()->find($request->order_id);
        if (!$order)
        {
            // error

         return $this->responseJson('0','errors','errors');
        }
        if ($order->status != 'pending')
        {
            // error

            return $this->responseJson('0','errors','تم رفض الطلب');
        }

        $order->update([ 'status' == 'accept' ]);//Order::STATUS_ACCEPTED;

        $client=Client::find($order->client_id);
        $notification=$client->notificationable()->create([
         'title'=>'تم قبول الطلب',
         'content'=>'تم قبول الطلب',
         'order_id'=>$order->id
        ]);
        $androidToken=$client->tokens()->where('type','android')->pluck('token')->toArray();
        $iosToken=$client->tokens()->where('type','ios')->pluck('token')->toArray();
        $title=$notification->title();
        $body=$notification->content();
        $data=[
            'user_type'=>'client',
            'action' =>'delivered-order',
            'order_id' => $order->id
        ];

        if (count($androidToken)) {

            // --------------send notification-------------------------------------------
            $send = notifyByFirebase($title, $body, $androidToken, $data);
            info($send);

        }

        if (count($iosToken)) {

            // --------------send notification-------------------------------------------
            $send = notifyByFirebase($title, $body, $iosToken, $data);

            info($send);
        }

        return $this->responseJson('1', 'تم قبول الطلب', $order);

    }

//----------------------refuse Order--------------------------
    public function refuseOrder(Request $request)
    {

        $order = $request->user()->order()->find($request->order_id);
        if (!$order)
        {
            // error
         return $this->responseJson('0','errors','errors');
        }
        if ($order->status != 'pending')
        {
            // error

            return $this->responseJson('0','errors','تم رفض الطلب');
        }

        $order->update([ 'status' == 'rejected' ]);//Order::STATUS_ACCEPTED;

        $client=Client::find($order->client_id);
        $notification=$client->notificationable()->create([
            'title'=>'تم رفض الطلب',
            'content'=>'تم رفض الطلب',
            'order_id'=>$order->id
        ]);
        $androidToken=$client->tokens()->where('type','android')->pluck('token')->toArray();
        $iosToken=$client->tokens()->where('type','ios')->pluck('token')->toArray();
        $title=$notification->title();
        $body=$notification->content();
        $data=[
            'user_type'=>'client',
            'action' =>'rejected-order',
            'order_id' => $order->id
        ];

        if (count($androidToken)) {

            // --------------send notification-------------------------------------------
            $send = notifyByFirebase($title, $body, $androidToken, $data);
            info($send);

        }

        if (count($iosToken)) {

            // --------------send notification-------------------------------------------
            $send = notifyByFirebase($title, $body, $iosToken, $data);
            info($send);

        }

        return $this->responseJson('1', 'تم رفض الطلب', $order);

    }

//----------------------confirm Order---------------
    public function confirmOrder(Request $request)
    {
        $order = $request->user()->order()->find($request->order_id);
        if (!$order)
        {
            // error
            return $this->responseJson('0','errors','errors');
        }
        if ($order->status != 'accepted')
        {
            // error

            return $this->responseJson('0','errors','تم رفض الطلب');
        }

        $order->update([ 'status' == 'confirmed' ]);//Order::STATUS_ACCEPTED;

        $client=Client::find($order->client_id);
        $notification=$client->notificationable()->create([
            'title'=>'تم تاكيد الطلب',
            'content'=>'تم تاكيد الطلب',
            'order_id'=>$order->id
        ]);
        $androidToken=$client->tokens()->where('type','android')->pluck('token')->toArray();
        $iosToken=$client->tokens()->where('type','ios')->pluck('token')->toArray();
        $title=$notification->title();
        $body=$notification->content();
        $data=[
            'user_type'=>'client',
            'action' =>'rejected-order',
            'order_id' => $order->id
        ];

        if (count($androidToken)) {

            // --------------send notification-------------------------------------------
            $send = notifyByFirebase($title, $body, $androidToken, $data);
            info($send);

        }

        if (count($iosToken)) {

            // --------------send notification-------------------------------------------
            $send = notifyByFirebase($title, $body, $iosToken, $data);

            info($send);
        }

        return $this->responseJson('1', 'تم تاكيد الطلب', $order);

    }

   //========================Notification==================

    public function notification(Request $request)
    {
        $notification = $request->user()->notificationable()->latest()->paginate(5);
        return $this->responseJson('1','Done',$notification);
    }

    //-----------------------------------------register-Token-------------------------------------------------

       public function registerToken(Request $request){
        $validator=Validator::make($request->all(),[

            'token'=>'required',
            'type'=>'required|in:andorid,ios',
        ]);

        if($validator->fails()) {
            return $this->responseJson('0',$validator->errors()->first(),$validator->errors());
        }

        Token::where('token',$request->token)->delete();
        $request->user()->tokens()->create($request->all());
        return $this->responseJson('1','تم التسجيل بنجاح');

    }
//-------------------------------------remove-Token---------------------------------------
    public function removeToken(Request $request){

        $validator=Validator::make($request->all(),[

            'token'=>'required',
        ]);

        if($validator->fails()) {
            return $this->responseJson('0',$validator->errors()->first(),$validator->errors());
        }

        Token::where('token',$request->token)->delete();
        return $this->responseJson('1',' token removed,ت م الحذف بنجاح');
    }
//-----------------------------------------------------------
//    public function logout(Request $request){
//
//        if(auth()->user()){
//         $user=auth()->user();
//         $user->api_token=null;
//         $user->save();
//            return $this->responseJson('1',' token removed,ت م الحذف بنجاح');
//        }




}
