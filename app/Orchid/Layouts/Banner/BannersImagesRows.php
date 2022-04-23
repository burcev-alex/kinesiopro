<?php
namespace App\Orchid\Layouts\Banner;

use Log;
use Orchid\Screen\Field;
use Orchid\Screen\Fields\Upload;
use Orchid\Screen\Layouts\Rows;

class BannersImagesRows extends Rows
{
    /**
     * Used to create the title of a group of form elements.
     *
     * @var string|null
     */
    protected $title;

    /**
     * Get the fields elements to be displayed.
     *
     * @return Field[]
     */
    protected function fields(): array
    {
        $banner = $this->query->get('banner');
        return [
            Upload::make('banner.images.attachment_id')
                ->value($banner->count() ? ($banner->attachment ? [$banner->attachment->id] : []) : [])
                ->title('Десктоп'),

            Upload::make('banner.images.attachment_mobile_id')
                ->value($banner->count() ? ($banner->attachment_mobile ? [$banner->attachment_mobile->id] : []) : [])
                ->title('Мобильное'),
        ];
    }
}
