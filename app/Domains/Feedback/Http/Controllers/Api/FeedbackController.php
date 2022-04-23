<?php

namespace App\Domains\Feedback\Http\Controllers\Api;

use App\Domains\Feedback\Models\FeedBack;
use App\Http\Controllers\Api\BaseController;
use Illuminate\Http\Request;
use Validator;

class FeedbackController extends BaseController
{

    /**
     * Обратная связь
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        return view('pages.feedback');
    }

    /**
     * Сохранить запрос с формы обратной связи
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
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
