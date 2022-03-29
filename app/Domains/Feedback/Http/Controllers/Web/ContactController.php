<?php

namespace App\Domains\Feedback\Http\Controllers\Web;

use App\Domains\Feedback\Services\ContactService;
use App\Http\Controllers\Api\BaseController;
use Illuminate\Http\Request;
use Validator;

class ContactController extends BaseController
{
    protected ContactService $contactService;

    /**
     * @param ContactService $productService
     */
    public function __construct(ContactService $contactService)
    {
        $this->contactService = $contactService;
    }

    public function index(Request $request)
    {
        // доступные контакты
        $items = $this->contactService->getList();

        return view('pages.contacts', ['items' => $items]);
    }
}
