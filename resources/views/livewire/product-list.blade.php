<div>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
        @foreach($products as $product)
        <x-product-preview :product="$product" />
        @endforeach

    </div>

    @if($hasMorePages)
    <div class="text-center my-4">
        <x-button type="primary" wire:click.prevent="loadProducts">more...</x-button>
    </div>
    <div x-data="{
                init () {
                    let observer = new IntersectionObserver((entries) => {
                        entries.forEach(entry => {
                            if (entry.isIntersecting) {
                                @this.call('loadProducts')
                            }
                        })
                    }, {
                        root: null
                    });
                    observer.POLL_INTERVAL = 100
                    observer.observe(this.$el);
                }
            }" class="grid grid-cols-1 gap-8 mt-4 md:grid-cols-1 lg:grid-cols-1">
    </div>
    @endif
</div>
