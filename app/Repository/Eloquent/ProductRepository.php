<?php

namespace App\Repository\Eloquent;


use App\Common\EloquentRepository;
use App\Common\Exceptions\ObjectNotFoundException;
use App\Models\Product;
use App\Repository\ProductRepositoryInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ProductRepository extends EloquentRepository implements ProductRepositoryInterface
{
    public function getModel()
    {
        return Product::class;
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

    public function syncTags($product, array $tagIds)
    {
        if ($product instanceof Product) {
            return $product->tags()->sync($tagIds);
        }
        return false;
    }

    public function attachTag($product, $tagId)
    {
        if ($product instanceof Product) {
            return $product->tags()->attach($tagId);
        }
        return false;
    }

    public function detachTag($product, $tagId)
    {
        if ($product instanceof Product) {
            return $product->tags()->detach($tagId);
        }
        return false;
    }
}