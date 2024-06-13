<x-t-input t="text" id="name" name="name" label="Nama Lengkap" />
<x-t-input t="email" id="email" name="email" label="Email" />
<x-t-input t="password" id="password" name="password" label="Password" />
<x-t-input t="password" id="password_confirmation" name="password_confirmation" label="Konfirmasi Password" />
<x-t-select id="role" name="role">
    <option value="Admin">{{ App\Role::Admin->value }}</option>
    <option value="Bendahara">{{ App\Role::Bendahara->value }}</option>
    <option value="Kasir">{{ App\Role::Kasir->value }}</option>
</x-t-select>
