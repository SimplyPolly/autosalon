<form id="createCarForm" method="POST" action="{{ route('admin.cars.store') }}" enctype="multipart/form-data">
    @csrf
    <div class="mb-3">
        <label for="id_марки" class="form-label">Марка</label>
        <input type="text" class="form-control" id="id_марки" name="id_марки" required>
    </div>
    <div class="mb-3">
        <label for="id_модели" class="form-label">Модель</label>
        <input type="text" class="form-control" id="id_moдели" name="id_модели" required>
    </div>
    <div class="mb-3">
        <label for="Год_выпуска" class="form-label">Год выпуска</label>
        <input type="number" class="form-control" id="Год_выпуска" name="Год_выпуска" required>
    </div>
    <div class="mb-3">
        <label for="VIN" class="form-label">VIN</label>
        <input type="text" class="form-control" id="VIN" name="VIN" required>
    </div>
    <div class="mb-3">
        <label for="Цена" class="form-label">Цена</label>
        <input type="number" class="form-control" id="Цена" name="Цена" step="0.01" required>
    </div>
    <div class="mb-3">
        <label for="id_салона" class="form-label">Салон</label>
        <select class="form-select" id="id_салона" name="id_салона" required>
            <option value="">Выберите салон</option>
            @foreach($salons as $salon)
                <option value="{{ $salon->id_салона }}">
                    {{ $salon->Название }}
                </option>
            @endforeach
        </select>
    </div>
    <div class="mb-3">
        <label for="id_статуса" class="form-label">Статус</label>
        <select class="form-select" id="id_статуса" name="id_статуса" required>
            <option value="1">В наличии</option>
            <option value="2">Забронирован</option>
            <option value="3">Продан</option>
            <option value="4">В ремонте</option>
            <option value="5">Зарезервировано</option>
        </select>
    </div>
    <div class="text-end">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Отмена</button>
        <button type="submit" class="btn btn-primary">Сохранить</button>
    </div>
</form> 