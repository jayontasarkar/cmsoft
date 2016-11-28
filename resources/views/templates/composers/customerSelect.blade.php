<select name="customer_id" required class="form-control select2">
    @foreach($customers as $customer)
        <option value="{{ $customer->id }}" {{ (isset($id) && $id == $customer->id) ? 'selected' : '' }}>
            {{ $customer->name }}
            ( {{ entobn($customer->phone) }} )
        </option>
    @endforeach
</select>