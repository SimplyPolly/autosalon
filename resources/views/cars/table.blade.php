@foreach($cars as $car)
    <tr class="@if($loop->odd) table-active @endif">
        {{-- Display Brand --}}
        <td>
            @if($car->brand && $car->brand->name)
                {{ $car->brand->name }}
            @else
                N/A
            @endif
        </td>
        {{-- Display Model --}}
        <td>{{ $car->model ? $car->model->name : '' }}</td>
        {{-- Display Year --}}
        <td>{{ $car->year }}</td>
        {{-- Display VIN --}}
        <td>{{ $car->vin ?? '' }}</td>
        {{-- Display Price --}}
        <td>{{ number_format($car->price, 2) }} ₽</td>
        {{-- Display Status --}}
        <td>
            <span class="badge bg-{{ $car->status && $car->status->name === 'In Stock' ? 'success' : 'warning' }}">
                {{ $car->status ? $car->status->name : '' }}
            </span>
        </td>
        {{-- Display Salon --}}
        <td>{{ $car->salon ? $car->salon->name : '' }}</td>
        {{-- Actions --}}
        <td>
            <div class="btn-group">
                <a href="{{ url('/cars/' . $car->id) }}" class="btn btn-sm btn-info me-2">Details</a>
                @auth('employee')
                    @if(Auth::guard('employee')->user()->role && Auth::guard('employee')->user()->role->name === 'Administrator')
                        <a href="{{ url('/employee/cars/' . $car->id . '/edit') }}" class="btn btn-sm btn-primary me-2">Edit</a>
                        <form action="{{ url('/employee/cars/' . $car->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this car?')">Delete</button>
                        </form>
                    @endif
                @endauth
            </div>
        </td>
    </tr>
@endforeach 