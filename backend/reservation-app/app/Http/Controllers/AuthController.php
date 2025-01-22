<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Traits\ApiResponseTrait;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\URL;
use App\Http\Resources\UserResource;
use Illuminate\Auth\Events\Verified;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Storage;
use App\Notifications\CustomVerifyEmail;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Events\PasswordReset;

class AuthController extends Controller
{
    use ApiResponseTrait;
    public function register(UserRequest $request)
    {
        try {
            $data = $request->validated();
            $data['password'] = Hash::make($data['password']);

            $user = User::create($data);


            // Handle image upload
            if ($request->hasFile('image')) {
                $this->storeImage($request, $user);
            }


            return $this->successResponse(
                [],
                'Kullanıcı başarıyla oluşturuldu. Lütfen e-posta adresinizi doğrulayın.',
                201
            );
        } catch (\Exception $e) {
            return $this->errorResponse('Kullanıcı oluşturulamadı', [$e->getMessage()], 500);
        }
    }


    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string'
        ]);

        if (!Auth::attempt($credentials)) {
            return $this->errorResponse('Giriş başarısız', 'Invalid email or password', 401);
        }

        $user = Auth::user();

        // // التحقق من حالة تأكيد البريد الإلكتروني
        // if (!$user->hasVerifiedEmail()) {
        //     return $this->errorResponse('Lütfen e-posta adresinizi doğrulayın.', 'Email not verified', 403);
        // }

        $token = $user->createToken('auth_token')->plainTextToken;

        $user->load(['role', 'image']);

        return $this->successResponse(
            new UserResource($user, $token),
            'Giriş başarılı',
            200
        );
    }



    public function logout(Request $request)
    {
        // Retrieve the token from the Authorization header
        $token = $request->bearerToken();

        // Check if a token was provided
        if ($token) {
            $user = $request->user(); // Get the authenticated user

            // Revoke all tokens for the user, if the token is valid
            $user->tokens->each(function ($token) {
                $token->delete();
            });

            return $this->successResponse([], 'Çıkış başarılı', 200);
        } else {
            return $this->errorResponse('Token not provided', 400); // Return an error if token is missing
        }
    }


    public function sendResetLink(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $status = Password::sendResetLink($request->only('email'));

        return $status === Password::RESET_LINK_SENT
            ? $this->successResponse([], 'Link gönderildi')
            : $this->errorResponse('Gönderim başarısız', __($status), 500);
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string|min:8|confirmed',
            'token' => 'required'
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->setRememberToken(Str::random(60));

                $user->save();
                event(new PasswordReset($user));
            }
        );

        return $status === Password::PASSWORD_RESET
            ? $this->successResponse([], 'Şifre başarıyla sıfırlandı')
            : $this->errorResponse('Şifre sıfırlanamadı', __($status), 500);
    }

    private function storeImage(Request $request, User $user)
    {
        $path = $request->file('image')->store('user_images', 'public');

        $user->image()->create([
            'url' => $path,  // Save relative path
        ]);
    }

    public function verify(Request $request, $id)
    {
        $user = User::findOrFail($id);

        if ($user->hasVerifiedEmail()) {
            return response()->json(['message' => 'Email already verified.'], 200);
        }

        if ($user->markEmailAsVerified()) {
            event(new Verified($user));
        }

        return response()->json(['message' => 'Email verified successfully.']);
    }

    public function redirect(Request $request, $id)
    {
        return redirect()->to("http://localhost:5173/uyeol/" . $id);
    }
}
