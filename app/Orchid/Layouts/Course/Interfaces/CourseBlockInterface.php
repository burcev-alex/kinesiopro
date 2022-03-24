<?php 


namespace App\Orchid\Layouts\Course\Interfaces;

interface CourseBlockInterface {    
    /**
     * render
     *
     * @return array
     */
    public function render() : array;
}