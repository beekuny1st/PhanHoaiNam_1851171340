<?php

namespace App\Repository\Eloquent;


use App\Common\EloquentRepository;
use App\Models\GalleryImage;
use App\Repository\GalleryImageRepositoryInterface;

class GalleryImageRepository extends EloquentRepository implements GalleryImageRepositoryInterface
{
    public function getModel()
    {
        return GalleryImage::class;
    }

}