<?php
namespace App\Services;

class RouterService
{
    /**
     * Detect Parameters
     *
     * @param array $params
     * @return mixed|null[]  Returned values are in next order [category1, filters]
     */
    public function detectParameters(array $params):array
    {
        $return = ['', '', 1];

        $filterSelected = false;
        foreach ($params as $key => $param) {
            if (strpos($param, '=') !== false) {
                $return[1] = $param;
                $filterSelected = true; // после того как фильтр найден то категории не трогать
            } elseif (strpos($param, 'page-') !== false) {
                $return[2] = (int) (explode('-', $param)[1] ?? 1);
            } elseif (!$filterSelected && !in_array($key, [1, 2])) {
                $return[$key] = $param;
            }
        }
        
        return $return;
    }

    public function detectParametersApplicability(array $params):array
    {
        $return = ['', '', 1];

        $filterSelected = false;
        foreach ($params as $key => $param) {
            if (strpos($param, '=') !== false) {
                $return[1] = $param;
                $filterSelected = true; // после того как фильтр найден то категории не трогать
            } elseif (strpos($param, 'page-') !== false) {
                $return[2] = (int) (explode('-', $param)[1] ?? 1);
            } elseif (!$filterSelected && !in_array($key, [1, 2])) {
                $return[$key] = $param;
            }
        }

        return $return;
    }

    /**
     * Detect Simple Pagination Params
     *
     * @param array $params
     * @return array
     */
    public function detectSimplePaginationParams(array $params)
    {
        $return = ['', 1];

        foreach ($params as $key => $param) {
            if (strpos($param, '=') !== false) {
                $return[0] = $param;
            } elseif (strpos($param, 'page-') !== false) {
                $return[1] = (int) (explode('-', $param)[1] ?? 1);
            }
        }

        return $return;
    }

    /**
     * Get list of array from path
     *
     * @return string
     */
    public function detectFiltersFromPath(): string
    {
        $filters = '';
        $path = request()->path();
        if ($path) {
            foreach (explode('/', $path) as $param) {
                if (strpos($param, '=') !== false) {
                    $filters = $param;
                    break;
                }
            }
        }

        return $filters;
    }

    /**
     * Get Pagination
     *
     * @param int $currentPage
     * @param int $lastPage
     * @return array
     */
    public function getPagination(int $currentPage, int $lastPage): array
    {
        $url = url()->current();

        $pagination = [
            'prev_url' => null,
            'next_url' => null,
            'current' => $currentPage,
            'last' => $lastPage
        ];
        
        $prevId = $currentPage - 1;
       
        if (strpos($url, '/page-' . $currentPage) !== false) {
            if ($currentPage > 1) {
                $pagination['prev_url'] = $prevId == 1
                    ? str_replace('/page-' . $currentPage, '', $url)
                    : str_replace('/page-' . $currentPage, '/page-' . ($currentPage - 1), $url);
            }
            if ($currentPage < $lastPage) {
                $pagination['next_url'] = str_replace('/page-' . $currentPage, '/page-' . ($currentPage + 1), $url);
            }
        } else {
            if ($currentPage > 1) {
                $prevId = 1;
                $pagination['prev_url'] = $url . ($prevId != 1 ? '/page-' . ($currentPage - 1) : '');
            }
            if ($currentPage < $lastPage) {
                $pagination['next_url'] = $url . '/page-' . ($currentPage + 1);
            }
        }

        return $pagination;
    }
}
