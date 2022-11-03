<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use App\Models\Feedback;
use App\Services\FeedbackService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FeedbackController extends Controller
{
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

    public function delete(Request $request, $id)
    {
        $data =  FeedbackService::delete($request->id);
        $data["success"] = true;
        $data["message"] = "تم حذف الرسالة بنجاح";
        return response()->json($data);
    }

    public function deleteAll()
    {
        FeedbackService::deleteAll();
        $data["success"] = true;
        $data["message"] = "تم حذف جميع الرسائل بنجاح";
        return response()->json($data);
    }
}
