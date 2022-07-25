<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use App\Models\Feedback;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FeedbackController extends Controller
{
    public function index()
    {
        $feedbacks = Feedback::latest()->paginate(5)->onEachSide(0);
        return view("dashboard.feedbacks.index", ["feedbacks" => $feedbacks]);
    }

    public function table()
    {
        $feedbacks = Feedback::latest()->paginate(5)->withPath(route('dashboard.feedbacks.index'))->onEachSide(0);
        return view("dashboard.feedbacks.table", ["feedbacks" => $feedbacks]);
    }
    public function show($id)
    {
        $feedback = Feedback::findOrFail($id);

        return view("dashboard.feedbacks.show", ["feedback" => $feedback]);
    }

    public function delete($id)
    {
        $feedback = Feedback::findOrFail($id);
        $feedback->delete();

        return redirect()->back()->with("success", "تم الحذف بنجاح");
    }

    public function deleteAll()
    {
        Feedback::truncate();
        $data["success"] = true;
        $data["message"] = "تم حذف جميع الرسائل بنجاح";
        return response()->json($data);
    }
}
