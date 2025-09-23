@foreach($carProducts as $product)
    <tr class="@if($loop->odd) table-active @endif"> {{-- Add class for alternating rows --}}
        <td>{{ $product->name ?? 'N/A' }}</td>
        <td>{{ $product->type->name ?? 'N/A' }}</td>
        <td>{{ number_format($product->price ?? 0, 2) }} ₽</td>
        <td>{{ $product->quantity ?? 'N/A' }}</td>
        <td>
            <div class="btn-group">
                <a href="{{ route('car-products.show', $product->id) }}" class="btn btn-sm btn-info me-2">Подробнее</a>
                @auth('employee')
                    @if(Auth::guard('employee')->user()->hasRole('Администратор'))
                        <a href="{{ route('admin.car-products.edit', $product->id) }}" class="btn btn-sm btn-primary me-2">Изменить</a>
                        <form action="{{ route('admin.car-products.destroy', $product->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Вы уверены, что хотите удалить этот товар?')">Удалить</button>
                        </form>
                    @endif
                @endauth
            </div>
        </td>
    </tr>
@endforeach 