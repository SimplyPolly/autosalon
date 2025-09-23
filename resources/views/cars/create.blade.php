@extends('layouts.app')

<body>
    <div class="container">
        <h1 class="mt-5">Add Car</h1>
        <a href="{{ route('cars.index') }}" class="btn btn-secondary">Back</a>

        <form action="{{ route('cars.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="brand_id">Brand</label>
                <select class="form-control" id="brand_id" name="brand_id" required>
                    @foreach($brands as $brand)
                        <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="model_id">Model</label>
                <select class="form-control" id="model_id" name="model_id" required>
                    @foreach($models as $model)
                        <option value="{{ $model->id }}">{{ $model->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="year">Year</label>
                <input type="number" class="form-control" id="year" name="year" min="1900" max="{{ date('Y') }}" required>
            </div>
            <div class="form-group">
                <label for="vin">VIN</label>
                <input type="text" class="form-control" id="vin" name="vin" required>
            </div>
            <div class="form-group">
                <label for="price">Price</label>
                <input type="number" class="form-control" id="price" name="price" step="0.01" required>
            </div>
            @auth('employee')
                <div class="mb-3">
                    <label for="status_id" class="form-label">Status</label>
                    <select class="form-select" id="status_id" name="status_id" required>
                        @foreach($carStatuses as $status)
                            <option value="{{ $status->id }}">{{ $status->name }}</option>
                        @endforeach
                    </select>
                </div>
            @endauth
            <div class="mb-3">
                <label for="salon_id" class="form-label">Salon</label>
                <select class="form-control" id="salon_id" name="salon_id" required>
                    @foreach($salons as $salon)
                        <option value="{{ $salon->id }}">{{ $salon->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label for="options" class="form-label">Опции</label>
                <select class="form-control" id="options" name="options[]" multiple>
                    @foreach($carOptions as $option)
                        <option value="{{ $option->id }}">{{ $option->name }}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Save</button>
        </form>
    </div>
</body>
</html>