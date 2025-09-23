<form id="editCarForm" method="POST" action="" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <div class="mb-3">
        <label for="edit_id_марки" class="form-label">Марка</label>
        <!-- Возможно, здесь нужно использовать выпадающий список марок из базы данных -->
        <input type="text" class="form-control" id="edit_id_марки" name="id_марки" required>
    </div>
    <div class="mb-3">
        <label for="edit_id_модели" class="form-label">Модель</label>
        <!-- Возможно, здесь нужно использовать выпадающий список моделей из базы данных, зависящий от выбранной марки -->
        <input type="text" class="form-control" id="edit_id_модели" name="id_модели" required>
    </div>
    <div class="mb-3">
        <label for="edit_Год_выпуска" class="form-label">Год выпуска</label>
        <input type="number" class="form-control" id="edit_Год_выпуска" name="Год_выпуска" required>
    </div>
     <div class="mb-3">
        <label for="edit_VIN" class="form-label">VIN</label>
        <input type="text" class="form-control" id="edit_VIN" name="VIN" required>
    </div>
    <div class="mb-3">
        <label for="edit_Цена" class="form-label">Цена</label>
        <input type="number" class="form-control" id="edit_Цена" name="Цена" step="0.01" required>
    </div>
    <div class="mb-3">
        <label for="edit_id_статуса" class="form-label">Статус</label>
        <select class="form-select" id="edit_id_статуса" name="id_статуса" required>
            <option value="1">В наличии</option>
            <option value="2">Забронирован</option>
            <option value="3">Продан</option>
            <option value="4">В ремонте</option>
            <option value="5">Зарезервировано</option>
        </select>
    </div>
    <div class="mb-3">
        <label for="edit_Фото" class="form-label">Фото</label>
        <input type="file" class="form-control" id="edit_Фото" name="Фото" accept="image/*">
    </div>
    <div class="text-end">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Отмена</button>
        <button type="submit" class="btn btn-primary">Сохранить</button>
</div>
</form> 