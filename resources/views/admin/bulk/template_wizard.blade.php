<form method="POST" action="{{ route('admin.generateTemplate') }}">
    @csrf

    Category:
    <input type="number" name="category_id" value="1"><br><br>

    Product Type:
    <select name="product_type">
        <option value="simple">Simple</option>
        <option value="variant">Variant</option>
    </select><br><br>

    Variant Attributes:
    <select name="variant_attributes[]" multiple>
        @foreach (\App\Models\Attribute::all() as $attr)
            <option value="{{ $attr->id }}">{{ $attr->name }}</option>
        @endforeach
    </select>
    
    Image Strategy:
    <select name="image_strategy">
        <option value="gallery">Gallery</option>
        <option value="attribute">Attribute</option>
    </select><br><br>

    Approx Volume:
    <input type="number" name="approx_volume" value="10"><br><br>

    <button type="submit">Download Template</button>
</form>
