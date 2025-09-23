<form id="createCarProductForm" method="POST" action="{{ route('admin.car-products.store') }}" enctype="multipart/form-data">
    @csrf
    <div class="mb-3">
        <label for="Название_товара" class="form-label">Название товара</label>
        <input type="text" class="form-control" id="Название_товара" name="Название_товара" required>
    </div>
    <div class="mb-3">
        <label for="Описание" class="form-label">Описание</label>
        <textarea class="form-control" id="Описание" name="Описание" rows="3"></textarea>
    </div>
    <div class="mb-3">
        <label for="Цена" class="form-label">Цена</label>
        <input type="number" class="form-control" id="Цена" name="Цена" step="0.01" required>
    </div>
    <div class="mb-3">
        <label for="id_типа_товара" class="form-label">Тип товара</label>
        <select class="form-select" id="id_типа_товара" name="id_типа_товара" required>
            <option value="">Выберите тип товара</option>
            @foreach($productTypes as $type)
                <option value="{{ $type->id_типа_товара }}">
                    {{ $type->Название_типа }}
                </option>
            @endforeach
        </select>
    </div>
    <div class="text-end">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Отмена</button>
        <button type="submit" class="btn btn-primary">Сохранить</button>
    </div>
</form> 