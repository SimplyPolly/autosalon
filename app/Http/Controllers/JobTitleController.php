<?php

namespace App\Http\Controllers;

use App\Models\JobTitle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class JobTitleController extends Controller
{
    public function index()
    {
        $table_headers = [
            ['sort' => 'id', 'label' => 'ID'],
            ['sort' => 'title', 'label' => 'Название должности'],
            ['sort' => 'daily_salary', 'label' => 'Ежедневная зарплата'],
        ];

        try {
            $jobTitlesCount = DB::table('job_titles')->count();
            
            // Если запрос выше отработал, то таблица существует.
            // Теперь попробуем оригинальный запрос с моделью:
            $jobTitles = JobTitle::get();
            return view('admin.job-titles.index', compact('jobTitles', 'table_headers'));
        } catch (\Exception $e) {
            // Если возникла ошибка, выведем ее для отладки
            dd($e->getMessage());
        }
    }

    public function create()
    {
        return view('admin.job-titles.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'Описание' => 'nullable|string',
            'daily_salary' => 'required|numeric|min:0'
        ]);

        JobTitle::create($validated);

        return redirect()->route('admin.job-titles.index')
            ->with('success', 'Должность успешно добавлена.');
    }

    public function show(JobTitle $jobTitle)
    {
        return view('admin.job-titles.show', compact('jobTitle'));
    }

    public function edit(JobTitle $jobTitle)
    {
        return view('admin.job-titles.edit', compact('jobTitle'));
    }

    public function update(Request $request, JobTitle $jobTitle)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'Описание' => 'nullable|string',
            'daily_salary' => 'required|numeric|min:0'
        ]);

        $jobTitle->update($validated);

        return redirect()->route('admin.job-titles.index')
            ->with('success', 'Должность успешно обновлена.');
    }

    public function destroy(JobTitle $jobTitle)
    {
        $jobTitle->delete();

        return redirect()->route('admin.job-titles.index')
            ->with('success', 'Должность успешно удалена.');
    }
}
