<select name="user_id" id="select-user" required class="form-control select2">
    @foreach($users as $user)
        <option value="{{ $user->id }}" {{ isset($id) && $id == $user->id ? 'selected' : '' }}>
            {{ $user->name }} ({{ $user->phone }})
        </option>
    @endforeach
</select>