<?php

namespace Streams\Core\Tests\Field\Types;

use Streams\Core\Tests\CoreTestCase;
use Streams\Core\Support\Facades\Streams;
use Streams\Core\Field\Types\ImageFieldType;
use Streams\Core\Field\Presenter\ImagePresenter;

class ImageFieldTypeTest extends CoreTestCase
{
    public function test_it_returns_image_presenter()
    {
        $field = new ImageFieldType([
            'stream' => Streams::make('films')
        ]);

        $this->assertInstanceOf(ImagePresenter::class, $field->decorate(''));
    }
}
