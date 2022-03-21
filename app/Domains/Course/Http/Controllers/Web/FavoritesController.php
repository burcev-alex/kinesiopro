<?php

namespace App\Domains\Product\Http\Controllers\Web;

use App\Domains\Order\Facades\Cart;
use App\Domains\Product\Models\Product;
use App\Domains\Product\Services\FavoritesService;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class FavoritesController extends Controller
{
    protected FavoritesService $favoritesService;
    protected Builder $query;

    /**
     * @param FavoritesService $favoritesService
     */
    public function __construct(FavoritesService $favoritesService)
    {
        $this->favoritesService = $favoritesService;

        $this->query = Product::query()->where('active', 1);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        if(request()->user()){
            $this->query->rightJoin('products_favorites', function ($join) {
                $join->on('products.id', '=', 'products_favorites.course_id');
    
                $join->on(function ($join) {
                    $userId = request()->user()->id ?? 0;
                    $join->orOn('user_id', DB::raw($userId));
                });
            });
        }
        else{
            $arItems = Cart::instance('wishlist')->content()->map(function($item){
                return $item->id;
            })->toArray();

        
            $this->query->whereIn('id', array_values($arItems))->with([
                'translation',
                'variants',
                'image' => function ($query) {
                    return $query->with('attachment');
                },
                'local_property_values' => function ($query) {
                    return $query->with('chars', function ($query) {
                        return $query->with('translation')
                            ->where('active', 1)->get()->toArray();
                    });
                },
                'local_option_values' => function ($query) {
                    return $query->with('ref_char', function ($query) {
                        return $query->with('translation')
                            ->where('active', 1)->get()->toArray();
                    })->with('ref_char_value');
                }
            ]);
        }

        $products = $this->query->get();

        foreach($products as $key_prod => $item){
            $charts = [];

            foreach($item->local_property_values as $charValue){ 
                if(empty($charts[$charValue->char_id]['value'])){$charts[$charValue->char_id]['value'] = [];}
                $charts[$charValue->char_id]['name'] = $charValue->char->translation->name;
                $charts[$charValue->char_id]['value'] = array_merge($charts[$charValue->char_id]['value'], [$charValue->id => $charValue->value]);
                $charts[$charValue->char_id]['valueText'] = implode (', ', $charts[$charValue->char_id]['value']);
            }
            $products[$key_prod]->charValue = $charts;
        }
        return view('pages.personal.favorites',['items' => $products]);
    }
}
