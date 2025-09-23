<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ConsultationRequest;
use App\Models\Employee;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class ConsultationRequestController extends Controller
{
    public function create()
    {
        return view('consultation_requests.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'notes' => 'nullable|string',
            'scheduled_at' => 'nullable|date',
        ]);

        $consultationRequest = ConsultationRequest::create([
            'user_id' => Auth::id(),
            'notes' => $request->notes,
            'scheduled_at' => $request->scheduled_at,
            'status' => 'pending', // Устанавливаем начальный статус
        ]);

        return redirect()->route('dashboard')->with('success', 'Заявка на консультацию успешно отправлена!');
    }

    public function index()
    {
        $consultationRequests = ConsultationRequest::with(['user', 'employee'])->get();

        $employees = collect(); // По умолчанию пустая коллекция
        // Проверяем, является ли текущий авторизованный сотрудник администратором
        if (Auth::guard('employee')->check() && Auth::guard('employee')->user()->jobTitle->title === 'Администратор') {
            $employees = Employee::all(); // Для выбора сотрудника при назначении (только для админа)
        }

        return view('consultation_requests.index', compact('consultationRequests', 'employees'));
    }

    public function show(ConsultationRequest $consultationRequest)
    {
        $employees = collect();
        if (Auth::guard('employee')->check() && Auth::guard('employee')->user()->jobTitle->title === 'Администратор') {
            $employees = Employee::all();
        }

        return view('consultation_requests.show', compact('consultationRequest', 'employees'));
    }

    public function update(Request $request, ConsultationRequest $consultationRequest)
    {
        // Этот метод будет использоваться для изменения статуса и назначения сотрудника администратором
        // Авторизованный пользователь должен быть администратором для смены сотрудника

        try {
            $request->validate([
                'status' => 'required|string',
                'employee_id' => [
                    'nullable',
                    Rule::exists(Employee::class, 'id'),
                ],
            ]);

            $consultationRequest->update([
                'status' => $request->status,
                'employee_id' => $request->employee_id,
            ]);

            return redirect()->route('employee.consultation-requests.index')
                ->with('success', 'Заявка на консультацию успешно обновлена!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Произошла ошибка при обновлении заявки: ' . $e->getMessage());
        }
    }

    public function takeInWork(ConsultationRequest $consultationRequest)
    {
        // Только авторизованный сотрудник может взять заявку в работу
        if (Auth::guard('employee')->check()) {
            $employee = Auth::guard('employee')->user();

            // Проверяем, что заявка в статусе 'pending' и не назначена другому сотруднику
            if ($consultationRequest->status === 'pending' && is_null($consultationRequest->employee_id)) {
                $consultationRequest->update([
                    'status' => 'in progress',
                    'employee_id' => $employee->id_сотрудника,
                ]);
                return redirect()->route('employee.consultation-requests.show', $consultationRequest->id)->with('success', 'Заявка успешно взята в работу!');
            } else if ($consultationRequest->employee_id === $employee->id_сотрудника) {
                return redirect()->route('employee.consultation-requests.show', $consultationRequest->id)->with('info', 'Вы уже взяли эту заявку в работу.');
            } else if (!is_null($consultationRequest->employee_id)) {
                return redirect()->route('employee.consultation-requests.show', $consultationRequest->id)->with('error', 'Эта заявка уже назначена другому сотруднику.');
            }
        }

        return redirect()->back()->with('error', 'Недостаточно прав для выполнения действия.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ConsultationRequest  $consultationRequest
     * @return \Illuminate\Http\Response
     */
    public function destroy(ConsultationRequest $consultationRequest)
    {
        $consultationRequest->delete();

        return redirect()->route('employee.consultation-requests.index')
            ->with('success', 'Заявка на консультацию успешно удалена!');
    }
}
