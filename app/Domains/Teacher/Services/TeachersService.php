<?php

namespace App\Domains\Teacher\Services;

use App\Services\BaseService;
use App\Domains\Teacher\Models\Teacher;

class TeachersService extends BaseService
{
    /**
     * __construct
     *
     * @param  Teacher $teacher
     * @return void
     */
    public function __construct(Teacher $teacher)
    {
        $this->query = Teacher::query()->where('active', true);

        $this->model = $teacher;
    }

    /**
     * Даные по преподавателю
     *
     * @param string $slug
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model|object|null
     */
    public function getBySlug(string $slug)
    {
        return Teacher::query()
            ->where('slug', $slug)->where('active', true)
            ->first();
    }

    /**
     * Список преподавателей
     *
     * @param string $filters
     * @param string $slug
     * @param int $page
     * @param int $perPage
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getList(int $page, int $perPage = 50)
    {
        $query = $this->model->active();

        return $query->where('active', true)->orderBy('sort', 'asc')->paginate($perPage, ['*'], 'page', $page);
    }

    public function save(array $fields): self
    {
        $this->model->fill($fields['teacher']);
        if (isset($fields['teacher']['active'])) {
            $this->model->active = true;
        } else {
            $this->model->active = false;
        }


        $this->model->save();

        return $this;
    }

    public function saveImages(array $images)
    {
        
        if (!isset($images['attachment_id'])) {
            $images['attachment_id'] = [];
        }
        
        foreach ($images as $key => $items) {
            foreach ($items as $item) {
                Teacher::where('id', $this->model->id)->update([$key => $item]);
            }
        }
    }
}
