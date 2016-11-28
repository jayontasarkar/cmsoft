<select name="business_id" id="select-business" required class="form-control select2">
    @foreach($businesses as $business)
    <option value="{{ $business->id }}" {{ isset($id) && $id == $business->id ? 'selected' : '' }} data-rate="{{ $business->rate }}">
        {{ $business->name }}
    </option>
    @endforeach
</select>