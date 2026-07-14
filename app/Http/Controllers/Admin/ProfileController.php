<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProfileRequest;
use App\Models\Profile;
use App\Services\CvService;
use App\Services\ThumbnailService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function __construct(
        private readonly ThumbnailService $thumbnails,
        private readonly CvService $cv,
    ) {}

    public function edit(): View
    {
        return view('admin.profile.edit', [
            'profile' => Profile::current(),
        ]);
    }

    public function update(ProfileRequest $request): RedirectResponse
    {
        $data = $request->profileData();
        $profile = Profile::current();

        if ($request->hasFile('photo')) {
            $this->thumbnails->delete($profile->photo, ThumbnailService::PHOTO_DIRECTORY);
            $data['photo'] = $this->thumbnails->store($request->file('photo'), ThumbnailService::PHOTO_DIRECTORY);
        } elseif ($request->boolean('remove_photo')) {
            $this->thumbnails->delete($profile->photo, ThumbnailService::PHOTO_DIRECTORY);
            $data['photo'] = null;
        }

        if ($request->hasFile('cv')) {
            $this->cv->delete($profile->cv_filename);
            $data['cv_filename'] = $this->cv->store($request->file('cv'));
        } elseif ($request->boolean('remove_cv')) {
            $this->cv->delete($profile->cv_filename);
            $data['cv_filename'] = null;
        }

        $profile->update($data);

        return back()->with('status', 'Perfil actualizado correctamente.');
    }
}
