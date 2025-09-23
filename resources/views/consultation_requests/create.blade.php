@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Создать заявку на консультацию') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('consultation-requests.store') }}">
                        @csrf

                        <div class="mb-3">
                            <label for="notes" class="form-label">{{ __('Заметки (необязательно)') }}</label>
                            <textarea class="form-control" id="notes" name="notes" rows="3">{{ old('notes') }}</textarea>
                            @error('notes')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="scheduled_at" class="form-label">{{ __('Предпочитаемая дата/время консультации (необязательно)') }}</label>
                            <input type="datetime-local" class="form-control" id="scheduled_at" name="scheduled_at" value="{{ old('scheduled_at') }}">
                            @error('scheduled_at')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary">{{ __('Отправить заявку') }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 