<x-form-section submit="updateProfileInformation">
    <x-slot name="title">
        <div class="d-flex align-items-center">
            <i class="fas fa-user-edit me-2 text-primary"></i>
            {{ __('Profile Information') }}
        </div>
    </x-slot>

    <x-slot name="description">
        {{ __('Update your account\'s profile information and email address.') }}
    </x-slot>

    <x-slot name="form">
        <!-- Profile Photo -->
        @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
            <div x-data="{photoName: null, photoPreview: null}" class="col-span-6 sm:col-span-4">
                <!-- Profile Photo File Input -->
                <input type="file" id="photo" class="hidden"
                            wire:model.live="photo"
                            x-ref="photo"
                            x-on:change="
                                    photoName = $refs.photo.files[0].name;
                                    const reader = new FileReader();
                                    reader.onload = (e) => {
                                        photoPreview = e.target.result;
                                    };
                                    reader.readAsDataURL($refs.photo.files[0]);
                            " />

                <x-label for="photo" value="{{ __('Profile Photo') }}" class="fw-bold" />

                <!-- Current Profile Photo -->
                <div class="mt-3 text-center" x-show="! photoPreview">
                    <div class="position-relative d-inline-block">
                        <img src="{{ $this->user->profile_photo_url }}" alt="{{ $this->user->name }}" class="rounded-circle" style="width: 120px; height: 120px; object-fit: cover; border: 3px solid #4CAF50;">
                        <div class="position-absolute bottom-0 end-0 bg-primary rounded-circle p-2" style="width: 35px; height: 35px; display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-camera text-white" style="font-size: 14px;"></i>
                        </div>
                    </div>
                </div>

                <!-- New Profile Photo Preview -->
                <div class="mt-3 text-center" x-show="photoPreview" style="display: none;">
                    <div class="position-relative d-inline-block">
                        <span class="d-block rounded-circle bg-cover bg-no-repeat bg-center"
                              style="width: 120px; height: 120px; border: 3px solid #4CAF50;"
                              x-bind:style="'background-image: url(\'' + photoPreview + '\');'">
                        </span>
                        <div class="position-absolute bottom-0 end-0 bg-success rounded-circle p-2" style="width: 35px; height: 35px; display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-check text-white" style="font-size: 14px;"></i>
                        </div>
                    </div>
                </div>

                <div class="mt-3 d-flex gap-2 justify-content-center">
                    <x-secondary-button class="btn btn-outline-primary" type="button" x-on:click.prevent="$refs.photo.click()">
                        <i class="fas fa-upload me-2"></i>
                        {{ __('Select New Photo') }}
                    </x-secondary-button>

                    @if ($this->user->profile_photo_path)
                        <x-secondary-button type="button" class="btn btn-outline-danger" wire:click="deleteProfilePhoto">
                            <i class="fas fa-trash me-2"></i>
                            {{ __('Remove Photo') }}
                        </x-secondary-button>
                    @endif
                </div>

                <x-input-error for="photo" class="mt-2" />
            </div>
        @endif

        <!-- Name -->
        <div class="col-span-6 sm:col-span-4">
            <x-label for="name" value="{{ __('Full Name') }}" class="fw-bold" />
            <div class="position-relative">
                <x-input id="name" type="text" class="mt-1 block w-full form-control" wire:model="state.name" required autocomplete="name" placeholder="Enter your full name" />
                <div class="position-absolute top-50 end-0 translate-middle-y pe-3">
                    <i class="fas fa-user text-muted"></i>
                </div>
            </div>
            <x-input-error for="name" class="mt-2" />
        </div>

        <!-- Email -->
        <div class="col-span-6 sm:col-span-4">
            <x-label for="email" value="{{ __('Email Address') }}" class="fw-bold" />
            <div class="position-relative">
                <x-input id="email" type="email" class="mt-1 block w-full form-control" wire:model="state.email" required autocomplete="username" placeholder="Enter your email address" />
                <div class="position-absolute top-50 end-0 translate-middle-y pe-3">
                    <i class="fas fa-envelope text-muted"></i>
                </div>
            </div>
            <x-input-error for="email" class="mt-2" />

            @if (Laravel\Fortify\Features::enabled(Laravel\Fortify\Features::emailVerification()) && ! $this->user->hasVerifiedEmail())
                <div class="alert alert-warning mt-3" role="alert">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    <strong>Email Verification Required</strong>
                    <p class="mb-2 mt-1">Your email address is unverified.</p>
                    <button type="button" class="btn btn-sm btn-outline-warning" wire:click.prevent="sendEmailVerification">
                        <i class="fas fa-paper-plane me-2"></i>
                        {{ __('Resend Verification Email') }}
                    </button>
                </div>

                @if ($this->verificationLinkSent)
                    <div class="alert alert-success mt-3" role="alert">
                        <i class="fas fa-check-circle me-2"></i>
                        {{ __('A new verification link has been sent to your email address.') }}
                    </div>
                @endif
            @endif
        </div>
    </x-slot>

    <x-slot name="actions">
        <div class="d-flex align-items-center gap-3">
            <x-action-message class="text-success" on="saved">
                <i class="fas fa-check-circle me-2"></i>
                {{ __('Profile updated successfully!') }}
            </x-action-message>

            <x-button wire:loading.attr="disabled" wire:target="photo" class="btn btn-primary">
                <i class="fas fa-save me-2"></i>
                {{ __('Save Changes') }}
            </x-button>
        </div>
    </x-slot>
</x-form-section>

<style>
.form-control {
    border-radius: 0.5rem;
    border: 1px solid #ced4da;
    padding: 0.75rem 1rem;
    padding-right: 2.5rem;
    height: auto;
    font-size: 1rem;
    transition: all 0.3s ease;
}

.form-control:focus {
    border-color: #4CAF50;
    box-shadow: 0 0 0 0.2rem rgba(76, 175, 80, 0.25);
}

.btn {
    border-radius: 0.5rem;
    padding: 0.75rem 1.5rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    transition: all 0.3s ease;
}

.btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
}

.btn-primary {
    background: #4CAF50;
    border-color: #4CAF50;
}

.btn-primary:hover {
    background: #45a049;
    border-color: #45a049;
}

.btn-outline-primary {
    color: #4CAF50;
    border-color: #4CAF50;
}

.btn-outline-primary:hover {
    background: #4CAF50;
    border-color: #4CAF50;
}

.alert {
    border-radius: 0.5rem;
    border: none;
}

.alert-warning {
    background-color: #fff3cd;
    color: #856404;
}

.alert-success {
    background-color: #d1e7dd;
    color: #0f5132;
}

.fw-bold {
    font-weight: 600 !important;
}

.text-primary {
    color: #4CAF50 !important;
}

.text-success {
    color: #28a745 !important;
}

.text-muted {
    color: #6c757d !important;
}
</style>
