<?php

namespace App\Http\Controllers;

use App\Http\Requests\SearchRequest;
use App\Http\Resources\GiphyResource;
use App\Http\Response\GiphyResponse;
use App\Service\GiphyService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class GiphyController extends Controller
{

    protected GiphyService $giphyService;

    public function __construct(GiphyService $giphyService)
    {
        $this->giphyService = $giphyService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(SearchRequest $request) : GiphyResource
    {
        $response = $this->giphyService->searchGif($request->q, $request->limit, $request->offset);
        return new GiphyResource($response);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $response = $this->giphyService->getById($id);
        return new GiphyResource($response);
    }

}
