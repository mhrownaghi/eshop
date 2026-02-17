<select name="category" onchange="this.form.submit()" id="category">
    <option value="" @selected($active == '')>None</option>
    @foreach ($productCategories as $productCategory)
        <option value="{{ $productCategory->slug }}" @selected($active == $productCategory->slug)>{{ $productCategory->name }}
        </option>
    @endforeach
</select>

@push('scripts')
    <script>
        new TomSelect("#category", {
            create: false,
            sortField: {
                field: "text",
                direction: "asc"
            }
        });
    </script>
@endpush