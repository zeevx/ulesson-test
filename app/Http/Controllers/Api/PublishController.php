<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ApiResponseHelper;
use App\Http\Controllers\Controller;
use App\Models\Topic;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class PublishController extends Controller
{
    /**
     * @param Request $request
     * @param $topic
     * @return JsonResponse
     */
    public function publish(Request $request, $topic): JsonResponse
    {
        $checkTopic = Topic::whereTitle($topic)->first();

        if (!$checkTopic){
            return ApiResponseHelper::errorResponse(422, "The topic: $topic does not exist", null);
        }

        $subscriptions = $checkTopic->subscriptions;

        if (count($subscriptions) == 0){
            return ApiResponseHelper::errorResponse(422, "Subscriptions for the topic: $topic does not exist", null);
        }

        $data = $request->all();
        $success_push = 0;
        $total_push = count($subscriptions);
        $errors = [];
        foreach ($subscriptions as $subscription){
            try {
                $push = Http::post($subscription->url, $data);
                if ($push->successful()) {
                    $success_push++;
                }
            }
            catch (\Exception $err) {
                array_push($errors, $err->getMessage());
                continue;
            }
        }

        return ApiResponseHelper::successResponse(200,"Content published successfully to $success_push out of $total_push, errors are shown below", $errors);

    }
}
