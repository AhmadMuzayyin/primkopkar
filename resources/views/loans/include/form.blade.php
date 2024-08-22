<x-t-select id="member_id" name="member_id" label="Member">
    <option value="" selected disableds>Pilih Member</option>
    @foreach ($members as $member)
        <option value="{{ $member->id }}"
            {{ isset($loan) ? ($loan->member_id == $member->id ? 'selected' : '') : '' }}>
            {{ $member->name }}</option>
    @endforeach
</x-t-select>
<x-t-select id="loan_category_id" name="loan_category_id" label="Kategori Pinjaman">
    <option value="" selected disabled>Pilih Kategori Pinjaman</option>
    @foreach ($categories as $loan_category)
        <option value="{{ $loan_category->id }}"
            {{ isset($loan) ? ($loan->loan_category_id == $loan_category->id ? 'selected' : '') : '' }}>
            {{ $loan_category->name }}</option>
    @endforeach
</x-t-select>
<x-t-input id="loan_nominal" name="loan_nominal" label="Jumlah Pinjaman" t="number" min="1"
    value="{{ $loan->loan_nominal ?? old('loan_nominal') }}" />
