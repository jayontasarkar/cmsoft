<select name="area_id" id="select-area" required class="form-control select2">
    @foreach($areas as $area)
        <option value="{{ $area->id }}" {{ isset($id) && $id == $area->id ? 'selected' : '' }}>
            {{ $area->name }}
        </option>
    @endforeach
</select>