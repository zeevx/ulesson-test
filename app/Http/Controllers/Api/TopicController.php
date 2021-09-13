<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ApiResponseHelper;
use App\Http\Controllers\Controller;
use App\Models\Topic;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TopicController extends Controller
{
    //Get All Topics
    public function index(): JsonResponse
    {
        $topics = Topic::all();
        if (count($topics) == 0){
            return ApiResponseHelper::errorResponse(422, 'No topics yet', null);
        }
        return ApiResponseHelper::successResponse(200, 'Topics fetched successfully', $topics);
    }


    //Create Topic

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $validate = Validator::make($request->all(), [
            'title' => 'required'
        ]);

        if ($validate->fails()){
            return ApiResponseHelper::errorResponse(422, $validate->messages()->first(), null);
        }

        $create = Topic::create($request->all());

        if (!$create){
            return ApiResponseHelper::errorResponse(422, 'An error occurred', null);
        }

        return ApiResponseHelper::successResponse(200, 'Topic created successfully',$create);

    }

    //Delete Topic

    /**
     * @param $id
     * @return JsonResponse
     */
    public function delete($id): JsonResponse
    {
        $topic = Topic::find($id);

        if (!$topic){
            return ApiResponseHelper::errorResponse(422, 'Topic not found', null);
        }

        $delete = $topic->delete();

        if (!$delete){
            return ApiResponseHelper::errorResponse(422, 'An error occurred', null);
        }

        return ApiResponseHelper::successResponse(200, 'Topic deleted successfully', null);
    }
}
