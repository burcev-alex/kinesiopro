<?php

namespace App\Domains\Product\Services;

use App\Domains\Product\Models\ProductsFavorite;
use App\Domains\Order\Facades\Cart;
use Illuminate\Support\Str;

/**
 * This is shit solution buy client wants see it as it is here, this can be full of not predicted bugs
 */
class FavoritesService
{
    /**
     * @param string|null $cookieId
     * @return int
     */
    public function count(string $cookieId = null): int
    {
        $user = $this->getUser();
        if (!$user) {
            return Cart::instance('wishlist')->count();
        }
        else{
            return ProductsFavorite::query()->where('user_id', $user->id)->count();
        }
    }

    /**
     * @param int $productId
     * @return mixed
     */
    public function store(int $productId) {
        $user = $this->getUser();
        if (!$user) {
            Cart::instance('wishlist')->add($productId, 'Product '.$productId, 1, 1);
        }
        else{
            ProductsFavorite::firstOrCreate([
                'user_id' => $user->id,
                'course_id' => $productId
            ]);
        }

        return true;
    }

    /**
     * @param int $productId
     */
    public function delete(int $productId)
    {
        $user = $this->getUser();
        if (!$user) {
            $arItems = Cart::instance('wishlist')->content();
            foreach($arItems as $rowId=>$item){
                if($item->id == $productId){
                    Cart::remove($rowId);
                }
            }
        }
        else{
            ProductsFavorite::query()
                ->where('user_id', $user->id)
                ->where('course_id', $productId)
                ->delete();
        }
    }

    /**
     * Destroy all favorites
     */
    public function destroy()
    {
        $user = $this->getUser();
        if (!$user) {
            Cart::instance('wishlist')->destroy();
        }
        else{
            ProductsFavorite::query()
            ->where('user_id', $user->id)
            ->delete();
        }
    }

    /**
     * При авторизации перенести все записи ил временного хранилища в БД
     * @param $userId
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Cookie\CookieJar|\Symfony\Component\HttpFoundation\Cookie|void|null
     */
    public static function synchronize($userId)
    {
        $arItems = Cart::instance('wishlist')->content()->map(function($item){
            return $item->id;
        })->toArray();

        foreach(array_values($arItems) as $productId){
            $rs  = ProductsFavorite::where('user_id', $userId)->where('course_id', $productId)->get()->first();
            if (! $rs) {
                ProductsFavorite::firstOrCreate([
                    'user_id' => $userId,
                    'course_id' => $productId,
                ]);
            }
        }

        Cart::instance('wishlist')->destroy();
    }

    /**
     * @param $cookieId
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Cookie\CookieJar|\Symfony\Component\HttpFoundation\Cookie
     */
    protected static function getCookie($cookieId)
    {
        return cookie('favorites', $cookieId, time() + (10 * 365 * 24 * 60 * 60));
    }

    /**
     * Get user
     * @return mixed
     */
    protected function getUser()
    {
        return request()->user();
    }
}
