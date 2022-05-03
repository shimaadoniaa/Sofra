<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\ResponseTrait;
use App\Model\Category;
use App\Model\City;
use App\Model\Comment;
use App\Model\Distriction;
use App\Model\Offer;
use App\Model\Payment;
use App\Model\Restaurant;
use App\Model\Setting;
use Illuminate\Http\Request;


class MainController extends Controller
{
    use ResponseTrait;

    public function setting()
    {

        $setting = Setting::first();
        return $this->responseJson('1', 'Done', $setting);
    }

//------------------City-----------------------------------------------
    public function cities(Request $request)
    {
        $cities = City::all();
        return $this->responseJson('1', 'done', $cities);

    }

    //------------------------Districtions------------------------------

    public function districtions(Request $request)
    {
        $districtions = Distriction::where(function ($q) use ($request) {

            if ($request->has('city_id')) {

                $q->where('city_id', $request->city_id);
            }

        })->get();
        return $this->responseJson('1', 'done', $districtions);
    }

//----------------get Offers--------------------

    public function offers()
    {
        $offers = Offer::all();
        return $this->responseJson('1', 'done', $offers);
    }

    //----------------get Offers--------------------

    public function offer(Request $request)
    {
        $offer = Offer::find($request->id);
        if ($offer) {
            return $this->responseJson('1', 'done', $offer);
        } else {
            return $this->responseJson('1', 'error', 'no offer');
        }
    }

    //---------------------Home All RESTAURANT-------------------
    public function Restaurants(Request $request)
    {
        $restaurants = Restaurant::where(function ($q) use ($request) {
            if ($request->restaurant_id) {
                $q->where('restaurant_id', $request->restaurant_id);
            }
            if ($request->distriction_id) {
                $q->where('distriction_id', $request->distriction_id);
            }
        })->paginate(10);

        return $this->responseJson('1', ' done', $restaurants);
    }

//-------------------get restaurant------------------------
    public function Restaurant(Request $request)
    {
        $restaurant = Restaurant::findOrfail($request->id);

        return $this->responseJson('1', ' done', $restaurant);

    }

    //--------------------get menu Products---------------------------
    public function menu(Request $request)
    {

        $restaurant = Restaurant::find($request->id);
        $products = $restaurant->product()->paginate(5);

        // $products = Product::where('restaurant_id',$request->id)->paginate(5);
        return $this->responseJson('1', ' done', $products);


    }

    //-------------get review------------------

    public function getReview(Request $request)
    {

        $comments = Comment::where('restaurant_id', $request->id)->paginate(5);
        return $this->responseJson('1', 'Done', $comments);
    }

    //----------------------get-order----------------------------------
    public function getOrder(Request $request)
    {

        $order = $request->user()->order()->get()->last();

        return $this->responseJson('1', 'done', '$order');
    }

    //---------------------categories-------------------------------------
    public function categories()
    {
        $categories = Category::all();
        return $this->responseJson(1, 'success', $categories);
    }
    //----------------Payment------------------------------------------
    public function payments()
     {

        $payments = Payment::all();
       return $this->responseJson(1, 'success', $payments);
     }





}
