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
     * Constructor
     *
     * @param ContactService $productService
     */
    public function __construct(ContactService $contactService)
    {
        $this->contactService = $contactService;
    }

    /**
     * Список контактов
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        // доступные контакты
        $items = $this->contactService->getList();

        return view('pages.contacts', ['items' => $items]);
    }
}
