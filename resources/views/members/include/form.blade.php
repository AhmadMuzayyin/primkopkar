<x-t-input t="text" id="name" name="name" label="Nama Member" value="{{ $member->name ?? '' }}" />
<x-t-input t="number" id="phone" name="phone" label="Nomor Telepon" value="{{ $member->phone ?? '' }}"
    min="62" />
<x-t-textarea id="address" name="address" label="Alamat Lengkap" value="{{ $member->address ?? '' }}" r="" />
