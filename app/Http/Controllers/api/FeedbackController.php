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
     *@response {
    "current_page": 1,
    "data": [
        {
            "id": 1,
            "name": "monty@gmail.com",
            "message": "السلام عليكم",
            "ip": "127.0.0.1",
            "created_at": "2022-11-15T09:32:51.000000Z",
            "updated_at": "2022-11-15T09:32:51.000000Z"
        }
    ],
    "first_page_url": "http://localhost:8000/api/feedbacks?page=1",
    "from": 1,
    "last_page": 1,
    "last_page_url": "http://localhost:8000/api/feedbacks?page=1",
    "links": [
        {
            "url": null,
            "label": "&laquo; Previous",
            "active": false
        },
        {
            "url": "http://localhost:8000/api/feedbacks?page=1",
            "label": "1",
            "active": true
        },
        {
            "url": null,
            "label": "Next &raquo;",
            "active": false
        }
    ],
    "next_page_url": null,
    "path": "http://localhost:8000/api/feedbacks",
    "per_page": 5,
    "prev_page_url": null,
    "to": 1,
    "total": 1
}
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        $feedbacks = FeedbackService::getAllFeedbacks();
        return response()->json($feedbacks);
    }

    /**
     * Store a newly created feedback in database (For guests).
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
     *@response {
    "id": 1,
    "name": "monty@gmail.com",
    "message": "السلام عليكم",
    "ip": "127.0.0.1",
    "created_at": "2022-11-15T09:32:51.000000Z",
    "updated_at": "2022-11-15T09:32:51.000000Z"
}
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
     * @response 200
     * {
    "id": 1,
    "name": "monty@gmail.com",
    "message": "السلام عليكم",
    "ip": "127.0.0.1",
    "created_at": "2022-11-15T09:32:51.000000Z",
    "updated_at": "2022-11-15T09:32:51.000000Z"
}

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
     * @response 200
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function destroyAll()
    {
        $data = FeedbackService::deleteAll();

        return response()->json($data);
    }
}
