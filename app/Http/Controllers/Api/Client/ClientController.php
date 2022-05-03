<?php

namespace App\Http\Controllers\Api\Client;
use App\Http\Controllers\Controller;
use App\Http\ResponseTrait;
use App\Model\Contact;
use App\Model\Distriction;

use App\Model\Product;
use App\Model\Restaurant;
use App\Model\Client;
use App\Model\Setting;
use App\Model\Order;
use App\Model\Token;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;




class ClientController extends Controller
{
    use ResponseTrait;


//----------------------Register----------------------------------------

    public function register(Request $request)
    {

        $validator = Validator::make($request->all(), [

            'email' => 'required|unique:restaurants',
            'name' => 'required',
            'password' => 'required|confirmed',
            'phone' => 'required',
            'distriction_id' => 'required',

        ]);
        if ($validator->fails()) {

            return $this->responseJson('0', $validator->errors()->first(), $validator->errors());
        }

        $request->merge(['password' => bcrypt($request->password)]);
        $client = Client::create($request->all());
        $client->api_token = Str::random('60');
        $client->save();

        if ($request->has('distriction_id')) {
            $distriction = Distriction::find($request->distriction_id)->get();

            //$client->city()->update(['distriction_id'=>$request->distriction_id]);
        }
        return $this->responseJson('1', 'done', $client);
    }
//----------------------End Register----------------------------------------

//----------------------Log in----------------------------------------

    public function login(Request $request)
    {

        $validator = Validator::make($request->all(), [

            'email' => 'required',

            'password' => 'required',


        ]);
        if ($validator->fails()) {

            return $this->responseJson('0', $validator->errors()->first(), $validator->errors());
        }
        $clients = Client::where('email', $request->email)->first();
        if ($clients) {

            if (Hash::check($request->password, $clients->password)) {

                return $this->responseJson('1', 'Done', ['api_token' => $clients->api_token, $clients]);

            }

            return $this->responseJson('0', 'error', 'error');


        }
        return $this->responseJson('0', $validator->errors()->first(), null);

    }
//------------------End login------------------

//--------------Reset password------------------------
    public function resetPassword(Request $request, $code)
    {

        $validator = Validator::make($request->all(), [
            'email' => 'required'
        ]);

        if ($validator->fails()) {
            return $this->responseJson('0', $validator->errors()->first(), $validator->errors());
        }
        // find  -  get -- all - paginate
        // create - update - firstOrCreate
        $client = Client::where('email', $request->email)->first();
        if ($client) {
            $client->pin_code = Str::random(8);
            $client->save();


            # send sms

            // smsMisr($request->phone,'your reset code is:'.$code);----------->>>>>>>


            # Send E-mail

            mail::to($client->email)
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
// -----------------------End ResetPassword------------------------------


// -----------------------New Pssword------------------------------

    public function newpassword(Request $request)
    {

        $validator = validator::make($request->all(), [
            'pin_code' => 'required',
            'email'=>'required',
            'password' => 'required|confirmed',
        ]);

        if ($validator->fails()) {
            return $this->responseJson('0', $validator->errors()->first(), $validator->errors());
        }

        $clients = Client::where('pin_code', $request->pin_code)->where('pin_code', '!=', '0')->where('email', $request->email)->first();

        if($clients)

        {
            $clients->password = bcrypt($request->password);
            $clients->password = null;
            $save = $clients->save();

            if ($save) {

                return $this->responseJson('0', 'تم تغير كلمة السر بنجاح', 'null');

            } else {
                return $this->responseJson('0', 'حدث خطا حاول مرة اخري', 'null');
            }
        } else {

            return $this->responseJson('0', 'هذا الكود غير صالح', 'null');
        }

    }


// ---------------End NewPassword------------------


//--------------------post order--------------------------
    public function order(Request $request)
    {

        $validator = validator::make($request->all(), [
            'restaurant_id' => 'required|exists:restaurants,id',
            'products.*.product_id' => 'required|exists:products,id',
            'products.*.amount' => 'required',
            'phone' => 'required',
            'address' => 'required',
            'delivery' => 'required',
            'payment_id' => 'required|exists:payments,id',
            'total' => 'required',


        ]);
        if ($validator->fails()) {
            return $this->responseJson('0', $validator->errors()->first(), $validator->errors());
        }
        $restaurant = Restaurant::find($request->restaurant_id);
        if ($restaurant->status == 'closed') {
            return $this->responseJson('0', 'المطعم مغلق');
        }

        $order = $request->user()->order()->create([
            'restaurant_id' => $request->restaurant_id,
            'note' => $request->node,
            'address' => $request->address,
            'delivery' => $restaurant->delivery_fees,
            //'status' => $request->status,
            'payment_id' => $request->payment_id,
            'phone' => $request->phone,

        ]);
        $total = 0;
        $delivery_fees= $restaurant->delivery_fees;
        foreach ($request->products as $p) {

            $product = Product::find($p['product_id']);
            $readyProduct = [
                $p['product_id'] => [

                    'amount' => $p['amount'],
                    'price' => $product->price,
                    'notes' => (isset($p['note'])) ? $p['note'] : ''
                ]
            ];
            $order->products()->attach($readyProduct);
            $total +=($product->price * $p['amount']);
        }


        if($total >= $restaurant->minimum_order) {
            $final_total = $total + $delivery_fees;
            $commission =Setting::first()->commission * $final_total / 100;
            $net = $total - $commission;

            $update = $order->update([
                'price' => $total,
                'delivery' => $delivery_fees,
                'total' => $final_total,
                'commission' => $commission,
                'net' => $net,
            ]);

            //====================notification================
            $notification = $restaurant->Notificationable()->create([
                'title' => 'You have a new order',
                'content' => 'You have a new order from ' . $request->user()->name,
                'order_id' => $order->id,
            ]);


            //----------get token for FCM---------------------------------------

            $androidtoken = $restaurant->tokens()->where('type', 'android')->pluck('token')->toArray();
            $iostoken = $restaurant->tokens()->where('type', 'ios')->pluck('token')->toArray();


            $title = $notification->title;
            $body = $notification->content;
            $data = [

                'order_id' => $order->id
            ];


            if (count($androidtoken)) {

                // --------------send notification-------------------------------------------
                $send = notifyByFirebase($title, $body, $androidtoken, $data);
                      info($send);

            }

            if (count($iostoken)) {

                // --------------send notification-------------------------------------------
                $send = notifyByFirebase($title, $body, $iostoken, $data);
                   info($send);

            }

            return $this->responseJson('1', 'Done, Added successfully', $order);
        }
        else{
            $order->products()->delete();
            $order->delete();
            return $this->responseJson('0','order could not be less than '.$restaurant->minimum_order.'pounds ');
        }
    }

    //--------------orders------------------------------------------------------
    public function orders(Request $request){

        $myOrders=$request->user()->order()->where(function($order)use($request){

         if($request->status == 'current'){

           $order->whereIn('status',['pending','accepted','confirmed']);
         }
         if($request->status == 'previous'){

            $order->whereNotIn('status',['pending','accepted','confirmed','cart']);
         }
        })->latest()->paginate(8);

        return $this->responseJson('1','Done',$myOrders);

    }


//------------post edit profile -------------------------

    public function profile(Request $request)
    {
        $validator = validator::make($request->all(),[
            'name' => 'required',
            'password' => 'confirmed',
            'email' => Rule::unique('clients')->ignore($request->user()->id), //rule????
            'phone' => Rule::unique('clients')->ignore($request->user()->id),
            'distriction_id' => 'required'
        ]);

        $user = $request->user();
        $user->update($request->only('email', 'phone', 'name', 'distriction_id'));

        if ($request->has('password')) {

            $user->password = bcrypt($request->password);
        }
        return $this->responseJson('1', 'done', $user);
    }









    //---------------------------accept--order-------------------------------------------------

    public function acceptOrder(Request $request){

        $order = $request->user()->order()->find($request->order_id);
        if (!$order)
        {
            // error

            return $this->responseJson('0','errors','لايمكن طلب الطعام');
        }
        if ($order->status != 'confirmed'){

            return $this->responseJson('0','errors','لايمكن طلب تاكيد الطعام');
        }
        $order->update(['status'=>'deliverd']);

        $restaurant=Restaurant::find($order->restaurant_id);
        $notification=$restaurant->Notificationable()->create([
          'title'=>'تم استلام الاوردر',
          'content'=>'تم استلام الاوردر من العميل'.$request->user()->name,
          'order_id'=>$order->id,
        ]);
        $androidToken=$restaurant->tokens()->where('type','android')->pluck('token')->toArray();
        $iosToken=$restaurant->tokens()->where('type','ios')->pluck('token')->toArray();
         $title=$notification->title();
         $body=$notification->content();
         $data=[
           'user_type'=>'restaurant',
           'action' =>'delivered-order',
           'order_id' => $order->id,
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

        return $this->responseJson('1', 'تم الاستلام بنجاح', $order);


    }


//--------------------------refuse-order--------------------------------------------------

    public function refuseOrder(Request $request)
    {

        $order = $request->user()->order()->find($request->order_id);
        if (!$order) {
            // error

            return $this->responseJson('0', 'errors', 'errors');
        }
        if ($order->status != 'confirmed') {
            return $this->responseJson('0', 'error', 'لا يمكن طلب الطعام');
        }
       $order->update(['status'== 'declined']);
       $restaurant=Restaurant::find($order->restaurant_id);
       $notification=$restaurant->notificationable()->create([
          'title'=>'تم رفض هذا الطلب ',
          'content'=>'تم رفض هذا الطلب ',
          'order_id'=>$order->id,
       ]);
      $androidToken=$restaurant->tokens()->where('type','android')->pluck('token')->toArray();
      $iosToken=$restaurant->tokens()->where('type','ios')->pluck('token')->toArray();
      $title=$notification->title;
      $body=$notification->content;
      $data=[
        'user_type'=>'restaurant',
        'action' =>'delivered-order',
        'order_id'=>$order->id,
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

        return $this->responseJson('1', 'تم الرفض', $order);
         }
//------------------notification----------------------------------------------------------

      public function notification(Request $request)
       {
        $notification = $request->user()->notificationable()->latest()->paginate(5);
        return $this->responseJson('1','Done',$notification);
       }


    //--------------- comment && Rate -----------------------

    public function review(Request $request)
    {
        $validator = validator()->make($request->all(),[
            'restaurant_id' => 'required|exists:restaurants,id',
            'comment' => 'required' ,
            'rate'  => 'required|in:1,2,3,4,5'
        ]);
        if($validator->fails())
        {
            return $this->responseJson('0',$validator->errors()->first(),$validator->errors());
        }

        $comment = $request->user()->comments()->create($request->all());
        return $this->responseJson('1', 'Done', $comment);

    }


      //------------ contactUs -----------------
      public function contactUs(Request $request)
       {
        $validator = Validator::make($request->all(), [


            'name' => 'required',
            'email' => 'required',
            'phone' => 'required',
            'msg' => 'required',
            'type' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->responseJson('0', $validator->errors()->first(), $validator->errors());
        }
        $contact = Contact::create($request->all());

        $contact->save();

        return $this->responseJson('1', 'تم ',$contact);
    }
  //---------------------------------register-Token-----------------------------------------------------

    public function registerToken(Request $request){
        $validator = Validator::make($request->all(),[

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
//----------------------------remove-Token------------------------------------------------
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





}
