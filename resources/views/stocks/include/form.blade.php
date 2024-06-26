<x-t-input t="text" id="name" name="name" label="Nama Kategori" value="{{ $category->name ?? '' }}" />
<x-t-input t="text" id="slug" name="slug" label="Slug" value="{{ $category->slug ?? '' }}" r="readonly" />
@push('js')
    <script>
        $(function() {
            let name = $('#name')
            name.on('keyup', function() {
                let slug = $('#slug')
                var slugeble = slugify(name.val())
                slug.val(slugeble)
            })
        })

        function slugify(str) {
            return String(str)
                .normalize('NFKD') // split accented characters into their base characters and diacritical marks
                .replace(/[\u0300-\u036f]/g,
                    '') // remove all the accents, which happen to be all in the \u03xx UNICODE block.
                .trim() // trim leading or trailing whitespace
                .toLowerCase() // convert to lowercase
                .replace(/[^a-z0-9 -]/g, '') // remove non-alphanumeric characters
                .replace(/\s+/g, '-') // replace spaces with hyphens
                .replace(/-+/g, '-'); // remove consecutive hyphens
        }
    </script>
@endpush
