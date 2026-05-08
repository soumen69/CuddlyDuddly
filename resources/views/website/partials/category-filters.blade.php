<ul class="megadown-list cartlist pr-3.5">
    @foreach ($filters as $filter)
        <li class="relative megadown-items">

            <a href="" class="w-full megalink inline-flex justify-between gap-4" tabindex="0">
                <span>{{ $filter['name'] }}</span>
                <i class="fa-solid fa-angle-down"></i>
            </a>

            <div class="megadropdown" bis_skin_checked="1">
                <div class="flex flex-col gap-4" bis_skin_checked="1">
                    <ul class="dropdown-list">

                        {{-- SELECT / MULTI SELECT --}}
                        @if ($filter['input_type'] === 'select' || $filter['input_type'] === 'multi-select')
                            @foreach ($filter['values'] as $value)
                                <li>

                                    <input type="checkbox" name="filters[{{ $filter['attribute_id'] }}][]"
                                        id="filter_{{ $filter['attribute_id'] }}_{{ $value->id }}"
                                        value="{{ $value->id }}" data-attribute="{{ $filter['attribute_id'] }}"
                                        class="ajax-filter">

                                    <label for="filter_{{ $filter['attribute_id'] }}_{{ $value->id }}">
                                        {{ $value->value }}
                                        @if (isset($value->count))
                                            <span class="text-gray-400 text-sm">
                                                ({{ $value->count }})
                                            </span>
                                        @endif
                                    </label>

                                </li>
                            @endforeach
                        @endif


                        {{-- BOOLEAN --}}
                        @if ($filter['input_type'] === 'boolean')
                            @foreach ($filter['values'] as $value)
                                <li>

                                    <input type="radio" name="filters[{{ $filter['attribute_id'] }}]"
                                        id="filter_{{ $filter['attribute_id'] }}_{{ $value->id }}"
                                        value="{{ $value->id }}" data-attribute="{{ $filter['attribute_id'] }}"
                                        class="ajax-filter">

                                    <label for="filter_{{ $filter['attribute_id'] }}_{{ $value->id }}">
                                        {{ $value->value }}
                                        @if (isset($value->count))
                                            <span class="text-gray-400 text-sm">
                                                ({{ $value->count }})
                                            </span>
                                        @endif
                                    </label>

                                </li>
                            @endforeach
                        @endif
                    </ul>
                </div>
            </div>

        </li>
    @endforeach

</ul>
