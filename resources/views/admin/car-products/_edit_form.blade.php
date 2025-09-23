<form id="editCarProductForm">
    <div class="modal-body">
        <input type="hidden" id="edit_car_product_id" name="id_товара">
        <div class="mb-3">
            <label for="edit_Название_товара" class="form-label">Название товара</label>
            <input type="text" class="form-control" id="edit_Название_товара" name="Название_товара" required>
        </div>
        <div class="mb-3">
            <label for="edit_Описание" class="form-label">Описание</label>
            <textarea class="form-control" id="edit_Описание" name="Описание"></textarea>
        </div>
        <div class="mb-3">
            <label for="edit_Цена" class="form-label">Цена</label>
            <input type="number" class="form-control" id="edit_Цена" name="Цена" step="0.01" required>
        </div>
        <div class="mb-3">
            <label for="edit_id_типа_товара" class="form-label">Тип товара</label>
            <select class="form-select" id="edit_id_типа_товара" name="id_типа_товара" required>
                <option value="">Выберите тип товара</option>
                @foreach($productTypes as $productType)
                    <option value="{{ $productType->id_типа_товара }}">
                        {{ $productType->Название_типа }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Отмена</button>
        <button type="submit" class="btn btn-primary">Сохранить изменения</button>
    </div>
</form> 