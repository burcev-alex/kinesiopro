<?php
namespace App\Domains\Feedback\Services;

use App\Domains\Feedback\Models\Contact;
use App\Exceptions\NoPageException;
use App\Services\BaseService;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class ContactService extends BaseService
{
    /**
     * __construct
     *
     * @param  Contact $contact
     * @return void
     */
    public function __construct(Contact $contact) {
        $this->model = $contact;
    }
    
    public function getList()
    {
        return $this->model->newQuery()->get();
    }
}
