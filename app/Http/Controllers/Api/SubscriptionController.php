<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ApiResponseHelper;
use App\Http\Controllers\Controller;
use App\Models\Subscription;
use App\Models\Topic;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SubscriptionController extends Controller
{
    /**
     * @param Request $request
     * @param $topic
     * @return JsonResponse
     */
    public function subscribe(Request $request, $topic): JsonResponse
    {
        $validate = Validator::make($request->all(), [
            'url' => 'required'
        ]);

        if ($validate->fails()){
            return ApiResponseHelper::errorResponse(422, $validate->messages()->first(), null);
        }
        $checkTopic = Topic::whereTitle($topic)->first();

        if (!$checkTopic){
            return ApiResponseHelper::errorResponse(422, "The topic: $topic does not exist", null);
        }

        $create = Subscription::create([
            'topic_id' => $checkTopic->id,
            'url' => $request->url
        ]);

        if (!$create){
            return ApiResponseHelper::errorResponse(500, 'An error occurred', null);
        }

        return ApiResponseHelper::successResponse(200, "Subscription to $topic successful", null);
    }

    /**
     * @param $topic
     * @return JsonResponse
     */
    public function unsubscribe($topic): JsonResponse
    {
        $checkTopic = Topic::whereTitle($topic)->first();

        if (!$checkTopic){
            return ApiResponseHelper::errorResponse(422, "The topic: $topic does not exist", null);
        }

        $subscriptions = $checkTopic->subscriptions;

        if (count($subscriptions) == 0){
            return ApiResponseHelper::errorResponse(422, "Subscriptions for the topic: $topic does not exist", null);
        }

        foreach ($subscriptions as $subscription){
            $subscription->delete();
        }

        return ApiResponseHelper::successResponse(200,"Subscriptions to $topic removed successfully", null);


    }

    /**
     * @param $topic
     * @return JsonResponse
     */
    public function subscribers($topic): JsonResponse
    {
        $checkTopic = Topic::whereTitle($topic)->first();

        if (!$checkTopic){
            return ApiResponseHelper::errorResponse(422, "The topic: $topic does not exist", null);
        }

        $subscriptions = $checkTopic->subscriptions;

        if (count($subscriptions) == 0){
            return ApiResponseHelper::errorResponse(422, "Subscriptions for the topic: $topic does not exist", null);
        }

        return ApiResponseHelper::successResponse(200, 'Subscriptions fetched successfully', $subscriptions);
    }
}
