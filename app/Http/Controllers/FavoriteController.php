<?php

namespace App\Http\Controllers;

use App\Exceptions\ExistFavorite;
use App\Http\Requests\FavoriteRequest;
use App\Models\Favorite;
use Illuminate\Http\Request;

class FavoriteController extends Controller
{

    public function __invoke(FavoriteRequest $request)
    {
        $favorite = Favorite::firstOrCreate([
            'gif_id' => $request->get('gif_id'),
            'user_id' => $request->get('user_id'),
        ],[
            'alias' => $request->get('alias'),
        ]);

        if(!$favorite->wasRecentlyCreated){
            throw new ExistFavorite('Favorite already exists', 409);
        }

        return response()->noContent();
    }
}
