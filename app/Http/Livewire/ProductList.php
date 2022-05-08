<?php

namespace App\Http\Livewire;

use App\Models\Product;
use Livewire\Component;
use Illuminate\Pagination\Cursor;
use Illuminate\Support\Collection;

class ProductList extends Component
{
    public $user_id;
    public $similar_to_product_id;
    public $products;
    public $nextCursor; // holds our current page position.
    public $hasMorePages; // Tells us if we have more pages to paginate.

    public function mount() {
        $this->products = new Collection();
        $this->loadProducts();
    }

    public function loadProducts() {
        if ($this->hasMorePages !== null  && !$this->hasMorePages) {
            return;
        }

        $query = Product::select('id','title','user_id','category_id','description','size','gender','tags')->with(['photos','user:id','category:id,name']);

        if (!is_null($this->user_id)) {
            $query->where(['user_id'=>$this->user_id]);
        }
        
        if (!is_null($this->similar_to_product_id)) {
            $similar_product = Product::find($this->similar_to_product_id);
            $query = $this->loadProductsSimilarTo($similar_product,$query);
        }

        $products = $query->cursorPaginate(
            8,
            ['*'],
            'cursor',
            Cursor::fromEncoded($this->nextCursor)
        );
        // convert new records to array and merge
        $this->products->push(...array_map(function($item) {return $item->toArray();}, $products->items()));
        $this->hasMorePages = $products->hasMorePages();
        if ($this->hasMorePages === true) {
            $this->nextCursor = $products->nextCursor()->encode();
        }
    }

    private function loadProductsSimilarTo($similar_product,$query) {

        $query->where('id','<>',$similar_product->id);

        $count = Product::where([
            'category_id' => $similar_product->category_id,
            'size' => $similar_product->size,
            'gender' => $similar_product->gender
        ])->count();
        if ($count > 4) {
            return $query->where([
                'category_id' => $similar_product->category_id,
                'size' => $similar_product->size,
                'gender' => $similar_product->gender
            ]);
        }

        $count = Product::where([
            'category_id' => $similar_product->category_id,
            'gender' => $similar_product->gender
        ])->count();
        if ($count > 4) {
            return $query->where([
                'category_id' => $similar_product->category_id,
                'gender' => $similar_product->gender
            ]);
        }

        $count = Product::where([
            'category_id' => $similar_product->category_id,
        ])->count();
        if ($count > 4) {
            return $query->where([
                'category_id' => $similar_product->category_id,
            ]);
        }

        return $query;

    }

    public function render()
    {
        return view('livewire.product-list');
    }
}
