<?php

namespace App\Http\Auth\Controllers;

use App\Http\Auth\Requests\UpdatePasswordRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;

class UpdatePasswordController
{
    public function edit()
	{
        return view('admin.auth.changePasswordForm');
    }

    public function update(UpdatePasswordRequest $request): RedirectResponse
    {
        $request->user()->update(['password' => Hash::make($request->password)]);

        return redirect()->route('admin.index');
    }
}
