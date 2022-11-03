<?php

namespace App\Services;

use App\Models\Feedback;

/**
 * Class FeedbackService.
 */
class FeedbackService
{

    public static function getAllFeedbacks()
    {

        $feedbacks = Feedback::latest()->paginate(5)->onEachSide(0);
        return $feedbacks;
    }

    public static function table($pageNumber)
    {

        $feedbacks = Feedback::latest()->paginate(5, ['*'], 'page', $pageNumber)->withPath(route('dashboard.feedbacks.index'))->onEachSide(0);
        return $feedbacks;
    }
    public static function show($id)
    {
        $feedback = Feedback::findOrFail($id);

        return $feedback;
    }
    public static function store($request)
    {



        // preg_match_all('#\bhttps?://[^,\s()<>]+(?:\([\w\d]+\)|([^,[:punct:]\s]|/))#', $request->message, $match);

        // return  preg_replace("#\bhttps?://[^,\s()<>]+(?:\([\w\d]+\)|([^,[:punct:]\s]|/))#", "<a href=$match[0]>$match[0]</a>", $request->message);

        $feedback =   Feedback::create([
            "name" => trim($request->name),
            "message" => trim($request->message),
            "ip" => $request->ip()
        ]);

        return $feedback;
    }
    public static function delete($id)
    {
        $feedback = Feedback::findOrFail($id);
        $feedback->delete();
        return $feedback;
    }

    public static function deleteAll()
    {
        Feedback::truncate();
        return true;
    }
}
