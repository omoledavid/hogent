<?php

namespace App\Http\Controllers\Saas;

use App\Http\Controllers\Controller;
use App\Http\Requests\OwnerRegisterRequest;
use App\Models\Owner;
use App\Models\Package;
use App\Models\User;
use App\Services\SmsMail\MailService;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class OwnerAuthController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function owner_register_form()
    {
        return view('auth.owner_register_form');
    }

    public function owner_register_store(OwnerRegisterRequest $request)
    {
        DB::beginTransaction();
        try {
            $user = new User();
            $user->first_name = $request->first_name;
            $user->last_name = $request->last_name;
            $user->contact_number = $request->contact_number;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $user->status = ACTIVE;
            $user->role = USER_ROLE_OWNER;
            $user->save();

            $owner = new Owner();
            $owner->user_id = $user->id;
            $owner->save();

            $duration = (int)getOption('trail_duration', 1);

            $defaultPackage = Package::where(['is_trail' => ACTIVE])->first();
            if ($defaultPackage) {
                setUserPackage($user->id, $defaultPackage, $duration);
            }

            setOwnerGateway($user->id);

            DB::commit();
            if (getOption('send_email_status') == ACTIVE) {
                $emails = [$user->email];
                $subject = getOption('app_name') . ' ' . __('welcome you');
                $message = __('You have successfully been registered');
                $ownerUserId = $user->id;

                $mailService = new MailService;
                $mailService->sendWelcomeMail($emails, $subject, $message, $ownerUserId);
            }
            $credentials = ['email' => $request->email, 'password' => $request->password];
            if (Auth::attempt($credentials)) {
                return redirect()->back()->with('success', __(CREATED_SUCCESSFULLY));
            } else {
                return redirect()->back()->with('error', __(SOMETHING_WENT_WRONG));
            }
        } catch (Exception $e) {
            DB::rollBack();
            return back()->with('error', $e->getMessage());
        }
    }
}
