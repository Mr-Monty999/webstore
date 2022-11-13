<?php

namespace App\Http\Controllers\general;

use App\Http\Controllers\Controller;
use App\Http\Requests\FeedbackRequest;
use App\Http\Requests\StoreFeedbackRequest;
use App\Models\Feedback;
use App\Services\FeedbackService;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Request as FacadesRequest;
use Illuminate\Support\Facades\Validator;

class FeedbackController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        return view("general.feedback");
    }




    public function store(StoreFeedbackRequest $request)
    {



        // preg_match_all('#\bhttps?://[^,\s()<>]+(?:\([\w\d]+\)|([^,[:punct:]\s]|/))#', $request->message, $match);

        // return  preg_replace("#\bhttps?://[^,\s()<>]+(?:\([\w\d]+\)|([^,[:punct:]\s]|/))#", "<a href=$match[0]>$match[0]</a>", $request->message);

        $feedback =  FeedbackService::store($request);

        return redirect()->back()->with("success", "تم ارسال الرسالة بنجاح شكرا لتواصلك معنا");
    }
}
