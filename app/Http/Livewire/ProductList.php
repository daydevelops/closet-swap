<?php

namespace App\Http\Livewire;

use App\Models\Product;
use Livewire\Component;
use Illuminate\Pagination\Cursor;
use Illuminate\Support\Collection;

class ProductList extends Component
{
    public $user_id;
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

        if (!is_null($this->user_id)) {
            $products = Product::select('id','title','user_id','category_id','description','size','tags')
            ->where(['user_id'=>$this->user_id])
            ->with(['photos','user:id,handle','category:id,name'])
            ->cursorPaginate(
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
    }

    public function render()
    {
        return view('livewire.product-list');
    }
}
