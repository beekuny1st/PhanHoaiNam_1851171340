<?php

namespace App\Repository\Eloquent;


use App\Common\EloquentRepository;
use App\Common\Exceptions\ObjectNotFoundException;
use App\Models\RelatedPost;
use App\Repository\RelatedPostRepositoryInterface;
use Illuminate\Support\Facades\DB;

class RelatedPostRepository extends EloquentRepository implements RelatedPostRepositoryInterface
{
    public function getModel()
    {
        return RelatedPost::class;
    }

    public function delete($id, $with = [])
    {
        $model = $id;
        if (is_numeric($id)) {
            $model = $this->findById($id);
        }
        if ($model) {
            $this->_model->where('order', '>', $model)->update([
                'order' => DB::raw('`order` - 1')
            ]);
            if ($model->delete()) {
                return true;
            } else {
                throw new \Exception('Không thể xóa');
            }
        } else {
            throw new ObjectNotFoundException();
        }
    }

}