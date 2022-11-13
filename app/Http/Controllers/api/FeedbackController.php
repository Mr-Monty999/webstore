<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreApiFeedbackRequest;
use App\Http\Requests\StoreFeedbackRequest;
use App\Services\FeedbackService;
use Illuminate\Http\Request;

class FeedbackController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {

        $this->middleware("permission:view-feedbacks")->only(["index", "show", "table"]);
        $this->middleware("permission:delete-feedbacks")->only("destroy", "destroyAll");
        $this->middleware("auth:sanctum")->except("store");
    }

    public function index()
    {
        $feedbacks = FeedbackService::getAllFeedbacks();
        return response()->json($feedbacks);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreApiFeedbackRequest $request)
    {
        $feedback =  FeedbackService::store($request);
        return response()->json($feedback, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $feedback = FeedbackService::show($id);

        return response()->json($feedback);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data =  FeedbackService::delete($id);
        return response()->json($data);
    }


    public function destroyAll()
    {
        $data = FeedbackService::deleteAll();

        return response()->json($data);
    }
}
