<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\User;
use App\Models\Clients;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Password;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Добавляем логирование для отладки
        Log::info('Login attempt for email: ' . $request->email);

        // Восстанавливаем стандартную попытку аутентификации через attempt()
        if (Auth::guard('employee')->attempt([
            'email' => $request->email,
            'password' => $request->password
        ])) {
            Log::info('Employee login successful: ' . $request->email);
            $request->session()->regenerate();
            return redirect()->intended('/employee/dashboard');
        }

        // Если не получилось, пробуем войти как клиент
        if (Auth::guard('web')->attempt([
            'email' => $request->email,
            'password' => $request->password
        ])) {
            Log::info('Client login successful: ' . $request->email);
            $request->session()->regenerate();
            return redirect()->intended('/dashboard');
        }

        Log::warning('Login attempt failed for email: ' . $request->email);

        return back()->withErrors([
            'email' => 'Предоставленные учетные данные не соответствуют нашим записям.',
        ])->withInput($request->only('email'));
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'Фамилия' => 'required|string|max:100',
            'Имя' => 'required|string|max:100',
            'Телефон' => 'required|string|max:15',
            'email' => ['required','string','email','max:50',Rule::unique('Клиенты', 'email')],
            'Пароль' => 'required|string|min:8|confirmed',
            'Адрес' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Создаем клиента
        $client = Clients::create([
            'Фамилия' => $request->Фамилия,
            'Имя' => $request->Имя,
            'Телефон' => $request->Телефон,
            'email' => $request->email,
            'Пароль' => Hash::make($request->Пароль),
            'Адрес' => $request->Адрес,
        ]);

        // Автоматический вход клиента
        Auth::guard('web')->login($client);

        return redirect('/dashboard');
    }

    public function logout(Request $request)
    {
        Auth::guard('web')->logout();
        Auth::guard('employee')->logout();
        
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect('/');
    }

    public function showForgotPasswordForm()
    {
        return view('auth.passwords.email');
    }

    public function sendResetLinkEmail(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $status = Password::sendResetLink(
            $request->only('email')
        );

        return $status === Password::RESET_LINK_SENT
            ? back()->with(['status' => __($status)])
            : back()->withErrors(['email' => __($status)]);
    }

    public function showResetPasswordForm($token)
    {
        return view('auth.passwords.reset', ['token' => $token]);
    }

    public function reset(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->save();
            }
        );

        return $status === Password::PASSWORD_RESET
            ? redirect()->route('login')->with('status', __($status))
            : back()->withErrors(['email' => __($status)]);
    }
} 