<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreApiFeedbackRequest;
use App\Http\Requests\StoreFeedbackRequest;
use App\Services\FeedbackService;
use Illuminate\Http\Request;

/**
 * @group feedbacks
 * @authenticated
 */

class FeedbackController extends Controller
{
    public function __construct()
    {

        $this->middleware("permission:view-feedbacks")->only(["index", "show", "table"]);
        $this->middleware("permission:delete-feedbacks")->only("destroy", "destroyAll");
        $this->middleware("auth:sanctum")->except("store");
    }


    /**
     * Display All Feedbacks (paginated)
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        $feedbacks = FeedbackService::getAllFeedbacks();
        return response()->json($feedbacks);
    }

    /**
     * Store a newly created feedback in database.
     *
     * @unauthenticated
     */
    public function store(StoreApiFeedbackRequest $request)
    {
        $feedback =  FeedbackService::store($request);
        return response()->json($feedback, 201);
    }

    /**
     * Display the specified feedback.
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
     * Update the specified feedback in database.
     * Not working for now!
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified feedback from database.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data =  FeedbackService::delete($id);
        return response()->json($data);
    }

    /**
     * Remove the all feedbacks from database.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function destroyAll()
    {
        $data = FeedbackService::deleteAll();

        return response()->json($data);
    }
}
