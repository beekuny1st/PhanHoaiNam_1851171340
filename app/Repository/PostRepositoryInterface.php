<?php

namespace App\Repository;


use App\Common\RepositoryInterface;

interface PostRepositoryInterface extends RepositoryInterface
{

    public function syncTags($id, $tagIds);

}