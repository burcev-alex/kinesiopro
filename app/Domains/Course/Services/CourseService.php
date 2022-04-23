<?php
namespace App\Domains\Course\Services;

use App\Domains\Course\Models\Course;
use App\Exceptions\NoPageException;
use App\Services\BaseService;

class CourseService extends BaseService
{
    /**
     * __construct
     *
     * @param  Course $course
     * @return void
     */
    public function __construct(Course $course)
    {
        $this->model = $course;
    }

    /**
     * WhereSlug
     *
     * @param  string $slug
     * @return Course
     * @throws NoPageException
     */
    public function whereSlug(string $slug) : Course
    {
        $model = $this->where('slug', $slug)->get()->first();
        if ($model === null) {
            throw new NoPageException('there is no course with slug like: ' . $slug);
        }

        return $model;
    }

    /**
     * Todo move it to cache
     *
     * @return int
     */
    public function getTotalActiveCourses(): int
    {
        return $this->model->newQuery()
            ->where('active', 1)
            ->count();
    }

    /**
     * Полная информация по курсу
     *
     * @param string $slug
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model|object|null
     */
    public function show(string $slug)
    {
        $builder = $this->model->newQuery()
            ->where('active', 1)
            ->where('slug', $slug)
            ->with([
                'property_values' => function ($query) {
                    return $query->with('chars', function ($query) {
                        return $query->where('active', 1);
                    });
                },
                'teachers',
                'components',
                'blocks'
            ])->get();
            
        if ($builder->count() > 0) {
            return $builder->first();
        } else {
            return false;
        }
    }

    /**
     * Курсы с применением фильтра
     *
     * @param array $options
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getCoursesByFilters(array $filters = [], array $orders = [], array $pagination = [], array $with = [])
    {
        $model = $this->newQuery()
            ->with($with);
        if ($filters) {
            foreach ($filters as $key => $value) {
                $model = $model->where($key, $value);
            }
        }

        return $model->orderBy(
            $orders['column'] ?? 'created_at',
            $orders['direction'] ?? 'desc'
        )->paginate($pagination['per_page'] ?? 5, ['*'], 'page', $pagination['page'] ?? 1);
    }
}
