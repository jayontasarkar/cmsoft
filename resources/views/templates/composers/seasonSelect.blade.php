<select name="season_id" required class="form-control select2" id="select-season">
    @foreach($seasons as $season)
        <option value="{{ $season->id }}" {{ ($season->active == 1) || (isset($id) && $id == $season->id) ? 'selected' : '' }}>
            {{ $season->name }}
            (
            {{ entobn($season->start_date->format('M Y')) }}
            @if($season->end_date)
                - {{ entobn($season->end_date->format('M Y')) }}
            @else
                - বর্তমান
            @endif
            )
        </option>
    @endforeach
</select>