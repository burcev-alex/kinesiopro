<?php

namespace App\View\Components\News;

use Illuminate\View\Component;

/**
 * Родительский компонент.
 * В него необходимо добавить свойства, необходимые для доступа в расширяющем компоненте.
 */
class MainComponent extends Component
{
    
    public ? int $number = null;

    public ? string $title = null;
    public ? string $text = null;
    public ? string $autor = null;
    public ? string $link = null;
    public ? string $type = null;
    
    public ? array $texts = null;
    public ? array $media = null;
    public ? array $list = null;
    public ? array $next = null;

    public ? array $key = null;


    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($number, $fields)
    {
        $this->number = $number;
        
        if (!empty($fields)) {
            foreach ($fields as $key => $value) {
                if ($key == 'media') {
                    foreach ($value as $attachment) {
                        if ($attachment) {
                            $originPath = $attachment->relativeUrl;
                            
                            // подмена origin на webp , если поддерживается формат
                            if (isSupportWebP() && !empty($originPath)) {
                                // конвертировать исходник в webp
                                convertImageToWebP($originPath);
                            }
                        }
                    }

                    $this->$key = $value;
                } else {
                    $this->$key = $value;
                }
            }
        }
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return 'parent';
    }
}
