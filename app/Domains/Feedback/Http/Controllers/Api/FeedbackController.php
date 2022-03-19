<?php

namespace App\Domains\Feedback\Http\Controllers\Api;

use App\Domains\Feedback\Models\FeedBack;
use App\Http\Controllers\Api\BaseController;
use Illuminate\Http\Request;
use Validator;

class FeedbackController extends BaseController
{

    public function index(Request $request)
    {
        return view('pages.feedback');
    }

    public function save(Request $request)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'name' => 'required',
            'telephone' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $fields = [
            'name' => $input['name'],
            'phone' => $input['telephone'] ?? '',
        ];
        $result = FeedBack::create($fields);

        return $this->sendResponse($result->toArray(), 'You have successfully uploaded.');
    }
}
