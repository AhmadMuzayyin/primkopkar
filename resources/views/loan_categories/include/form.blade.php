<x-t-input t="text" id="name" name="name" label="Nama Kategori" value="{{ $loan_category->name ?? '' }}" />
<x-t-input t="number" id="margin" name="margin" label="Margin" min="1"
    value="{{ $loan_category->margin ?? '' }}" />
