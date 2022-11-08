<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use App\Models\Feedback;
use App\Services\FeedbackService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;



class FeedbackController extends Controller
{
    public function __construct()
    {

        $this->middleware("permission:view-feedbacks")->only(["index", "show", "table"]);
        $this->middleware("permission:delete-feedbacks")->only("destroy", "destroyAll");
    }


    public function index()
    {
        $feedbacks = FeedbackService::getAllFeedbacks();
        return view("dashboard.feedbacks.index", ["feedbacks" => $feedbacks]);
    }

    public function table($pageNumber)
    {

        $feedbacks = FeedbackService::table($pageNumber);
        return view("dashboard.feedbacks.table", ["feedbacks" => $feedbacks]);
    }
    public function show($id)
    {
        $feedback = FeedbackService::show($id);

        return view("dashboard.feedbacks.show", ["feedback" => $feedback]);
    }

    public function destroy(Request $request, $id)
    {
        $data =  FeedbackService::delete($request->id);
        $data["success"] = true;
        $data["message"] = "تم حذف الرسالة بنجاح";
        return response()->json($data);
    }

    public function destroyAll()
    {
        FeedbackService::deleteAll();
        $data["success"] = true;
        $data["message"] = "تم حذف جميع الرسائل بنجاح";
        return response()->json($data);
    }
}
