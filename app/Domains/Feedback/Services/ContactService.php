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
    public function __construct(Contact $contact)
    {
        $this->model = $contact;
    }

    public function save(array $fields): self
    {
        if (array_key_exists('phoneList', $fields)) {
            $fields['phone'] = $fields['phoneList'];
            
            if (is_array($fields['phone'])) {
                foreach ($fields['phone'] as $key => $phone) {
                    if (strlen($phone) == 0) {
                        unset($fields['phone'][$key]);
                    }
                }
            }

            unset($fields['phoneList']);
        }

        $this->model->fill($fields);

        $this->model->save();

        return $this;
    }
    
    public function getList()
    {
        return $this->model->newQuery()->get();
    }
}
