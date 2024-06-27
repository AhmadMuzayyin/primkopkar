<x-t-input t="text" id="name" name="name" label="Nama Barang" value="{{ $product->name ?? '' }}" />
<x-t-select id="categori_id" name="category_id" label="Kategori Barang">
    @foreach ($categories as $category)
        <option value="{{ $category->id }}" @if (isset($product) && $product->category_id == $category->id) selected @endif>
            {{ $category->name }}
        </option>
    @endforeach
</x-t-select>
<x-t-textarea id="description" name="description" label="Deskripsi" value="{{ $product->description ?? '' }}" />
<x-t-input t="number" id="purchase_price" name="purchase_price" label="Harga Beli"
    value="{{ $product->purchase_price ?? '' }}" min="1" />
<x-t-input t="number" id="margin" name="margin" label="Margin" value="{{ $product->margin ?? '' }}"
    min="1" />
<x-t-input t="number" id="stock" name="stock" label="Stok" value="{{ $product->stock ?? '' }}" min="1" />
<x-t-input t="number" id="shu" name="shu" label="SHU" value="{{ $product->shu ?? '' }}" min="1" />
<x-t-input t="number" id="price" name="price" label="Harga Tunai" value="{{ $product->price ?? '' }}"
    min="1" />
<x-t-input t="number" id="price_credit" name="price_credit" label="Harga Kredit"
    value="{{ $product->price_credit ?? '' }}" min="1" />
