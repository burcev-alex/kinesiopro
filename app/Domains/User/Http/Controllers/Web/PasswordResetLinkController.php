<?php

namespace App\Domains\User\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Domains\User\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\ValidationException;

class PasswordResetLinkController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws ValidationException
     */
    public function store(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
        ]);
        
        // We will send the password reset link to this user. Once we have attempted
        // to send the link, we will examine the response then see the message we
        // need to show to the user. Finally, we'll send out a proper response.
        $status = Password::sendResetLink(
            $request->only('email')
        );

        if ($status == Password::INVALID_USER) {
            return response()->json([
                'errors' => [
                    'email' => __($status)
                ],
                'message' => 'The given data was invalid.'
            ], 422);
        }

        if ($status == Password::RESET_LINK_SENT) {
            return response()->json([
                'message' => __($status)
            ]);
        }

        throw ValidationException::withMessages([
            'email' => __($status)
        ]);
    }
}
