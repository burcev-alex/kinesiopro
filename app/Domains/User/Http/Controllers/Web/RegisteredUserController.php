<?php

namespace App\Domains\User\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Domains\User\Models\User;
use App\Domains\User\Http\Requests\RequestUserRegister;
use Illuminate\Auth\Events\Registered;
use Illuminate\Notifications\Notification;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Orchid\Attachment\File;

class RegisteredUserController extends Controller
{
    /**
     * Регистрация пользоваеля в системе
     *
     * @param RequestUserRegister $request
     * @return \Illuminate\Http\JsonResponse
     * @throws ValidationException
     */
    public function store(RequestUserRegister $request)
    {
        $data = $request->validated();

        $email = strtolower($data['email']);
        $user = User::query()
            ->where('email', $email)
            ->first();

        $phone = User::query()
            ->where('phone', $data['phone'])
            ->exists();

        if ($phone) {
            throw ValidationException::withMessages([
                'phone' => __('auth.registration.phone_exists'),
            ]);
        }

        if ($user) {
            if (empty($user->password)) {
                $user->update([
                    'name' => $data['surname']." ".$data['firstname'],
                    'firstname' => $data['firstname'],
                    'surname' => $data['surname'],
                    'work' => $data['work'],
                    'position' => $data['position'],
                    'country' => $data['country'],
                    'phone' => $data['phone'],
                    'password' => $data['password']
                ]);
            } else {
                throw ValidationException::withMessages([
                    'email' => __('auth.registration.email_exists'),
                ]);
            }
        } else {
            try {
                DB::beginTransaction();

                if (strlen($data['birthday_year']) > 0 &&
                strlen($data['birthday_month']) > 0 &&
                strlen($data['birthday_day']) > 0) {
                    $birthday = $data['birthday_year']."-";
                    $birthday .= $data['birthday_month']."-";
                    $birthday .= $data['birthday_day'];
                } else {
                    $birthday = null;
                }

                $fields = [
                    'name' => $data['surname']." ".$data['firstname'],
                    'firstname' => $data['firstname'],
                    'surname' => $data['surname'],
                    'email' => $email,
                    'phone' => $data['phone'],
                    'work' => $data['work'],
                    'birthday' => $birthday,
                    'position' => $data['position'],
                    'country' => $data['country'],
                    'password' => $data['password'],
                ];

                // загрузка аватар
                if ($request->avatar_id) {
                    $uploaded = new UploadedFile($request->avatar_id->path(), md5($email)."_avatar.jpg");
                    $file = new File($uploaded, 'public');
                    $attach = $file->load();

                    $fields['avatar_id'] = $attach->id;
                }

                // загрузка скан.копий документов
                if ($request->scan_id) {
                    $uploaded = new UploadedFile($request->scan_id->path(), md5($email)."_scan.jpg");
                    $file = new File($uploaded, 'public');
                    $attach = $file->load();

                    $fields['scan_id'] = $attach->id;
                }

                $user = User::create($fields);
                
                event(new Registered($user));
                
                Auth::login($user);
                DB::commit();
            } catch (\Exception $exception) {
                DB::rollBack();
                throw $exception;
            }
        }

        return response()->json([
            'message' => __('auth.registration.success'),
        ]);
    }

    public function create()
    {
        return view('pages.registration');
    }
}
