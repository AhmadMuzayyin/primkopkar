<x-t-input t="text" id="name" name="name" label="Nama Lengkap" value="{{ $user->name ?? '' }}" />
<x-t-input t="email" id="email" name="email" label="Email" value="{{ $user->email ?? '' }}" />
<x-t-input t="password" id="password" name="password" label="Password" />
<x-t-input t="password" id="password_confirmation" name="password_confirmation" label="Konfirmasi Password" />
<x-t-select id="role" name="role">
    <option value="Admin"{{ isset($user) ? ($user->role == App\Role::Admin->value ? 'selected' : '') : '' }}>
        {{ App\Role::Admin->value }}</option>
    <option value="Bendahara" {{ isset($user) ? ($user->role == App\Role::Bendahara->value ? 'selected' : '') : '' }}>
        {{ App\Role::Bendahara->value }}</option>
    <option value="Kasir"{{ isset($user) ? ($user->role == App\Role::Kasir->value ? 'selected' : '') : '' }}>
        {{ App\Role::Kasir->value }}</option>
    <option value="Kasir"{{ isset($user) ? ($user->role == App\Role::Jasa->value ? 'selected' : '') : '' }}>
        {{ App\Role::Jasa->value }}</option>
</x-t-select>
