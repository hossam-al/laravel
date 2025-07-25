@extends('paymob.layout.app')

@section('content')

    <section class="section profile">
        <div class="row">
            {{-- الجزء الأيسر - الصورة --}}
            <div class="col-xl-4">
                <div class="card">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        @if (Session::has('success'))
            <div class="alert alert-success">
                {{ Session::get('success') }}
            </div>
        @endif
          @if (Session::has('error'))
            <div class="alert alert-danger">
                {{ Session::get('error') }}
            </div>
        @endif
                    <form method="POST" action="{{ route('profile.change_image',  $user->id) }}" enctype="multipart/form-data">
                        @csrf

                        <div class="card-body profile-card d-flex flex-column align-items-center">
                            {{-- صورة البروفايل --}}
                            <img id="profilePreview"
                                src="{{ $user->image
                                    ? asset('upload/' . $user->image)
                                    : 'https://imgs.search.brave.com/gZ3W9GjnWyv8g9cDfw1qrVag80rOPbBgaMDkSRu3z40/rs:fit:860:0:0:0/g:ce/aHR0cHM6Ly9jZG4u/dmVjdG9yc3RvY2su/Y29tL2kvcHJldmll/dy0xeC8wOC82MS9w/ZXJzb24tZ3JheS1w/aG90by1wbGFjZWhv/bGRlci1saXR0bGUt/Ym95LXZlY3Rvci0y/MzE5MDg2MS5qcGc' }}"
                                class="rounded-circle shadow mb-3" alt="Admin Profile Image"
                                style="width: 150px; height: 150px; object-fit: cover;">

                            {{-- زر رفع الصورة --}}
                            <label for="upload_image" class="btn btn-outline-primary btn-sm mb-3">
                                <i class="bi bi-upload me-1"></i> Upload New Image
                            </label>
                            <input type="file" accept="image/*" name="image" class="d-none" id="upload_image">
                            {{-- زر الحفظ --}}
                            <div id="saveChangesContainer" class="text-center mt-2" style="display: none;">
                                <button type="submit" class="btn btn-success px-4 fw-semibold">
                                    💾 Save Changes
                                </button>
                            </div>
                        </div>
                    </form>
                    <form method="POST" action="{{ route('profile.delete_image', $user->id) }}" enctype="multipart/form-data">
                        @csrf
                        <button type="submit" class="btn btn-outline-danger btn-sm mb-3">
                            <i class="bi bi-trash"></i> Delete Image
                        </button>
                    </form>

                    <div class="text-center pb-4">
                        <h2>{{ $user->name }}</h2>
                        <h5 class="text-muted">Web Designer</h5>
                        <div class="social-links mt-2">
                            <a href="#" class="twitter me-2"><i class="bi bi-twitter"></i></a>
                            <a href="#" class="facebook me-2"><i class="bi bi-facebook"></i></a>
                            <a href="#" class="instagram me-2"><i class="bi bi-instagram"></i></a>
                            <a href="#" class="linkedin"><i class="bi bi-linkedin"></i></a>
                        </div>
                    </div>
                </div>
            </div>

            {{-- الجزء الأيمن - Tabs --}}
            <div class="col-xl-8">
                <div class="card">
                    <div class="card-body pt-3">
                        <ul class="nav nav-tabs nav-tabs-bordered">
                            <li class="nav-item">
                                <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#profile-edit">
                                    Edit Profile
                                </button>
                            </li>
                            <li class="nav-item">
                                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-change-password">
                                    Change Password
                                </button>
                            </li>
                        </ul>

                        <div class="tab-content pt-2">
                            {{-- Edit Profile --}}
                            <div class="tab-pane fade show active profile-edit pt-3" id="profile-edit">
                                <div class="p-4 bg-white shadow-sm rounded">
                                    @include('profile.partials.update-profile-information-form')
                                </div>
                            </div>

                            {{-- Change Password --}}
                            <div class="tab-pane fade pt-3" id="profile-change-password">
                                @if ($errors->any())
                                    <div class="alert alert-danger">
                                        <ul class="mb-0">
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif

                                @include('profile.partials.update-password-form')
                                {{-- نقل زر حذف الصورة بجانب زر رفع الصورة --}}
                                <style>
                                    .profile-action-buttons {
                                        display: flex;
                                        gap: 0.5rem;
                                        justify-content: center;
                                        margin-bottom: 1rem;
                                    }
                                </style>
                                <script>
                                    // نقل زر الحذف بجانب زر الرفع بعد تحميل الصفحة
                                    document.addEventListener('DOMContentLoaded', function() {
                                        const uploadLabel = document.querySelector('label[for="upload_image"]');
                                        const deleteForm = document.querySelector('form[action*="delete_image"]');
                                        if (uploadLabel && deleteForm) {
                                            // إنشاء حاوية للأزرار إذا لم تكن موجودة
                                            let btnContainer = uploadLabel.parentElement.querySelector('.profile-action-buttons');
                                            if (!btnContainer) {
                                                btnContainer = document.createElement('div');
                                                btnContainer.className = 'profile-action-buttons';
                                                uploadLabel.parentElement.insertBefore(btnContainer, uploadLabel);
                                            }
                                            btnContainer.appendChild(uploadLabel);
                                            btnContainer.appendChild(deleteForm);
                                        }
                                    });
                                </script>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Script لعرض المعاينة وإظهار الزر --}}
        <script>
            const imageInput = document.getElementById('upload_image');
            const previewImg = document.getElementById('profilePreview');
            const saveBtnContainer = document.getElementById('saveChangesContainer');

            imageInput.addEventListener('change', function() {
                const file = this.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        previewImg.src = e.target.result;
                        saveBtnContainer.style.display = 'block';
                    };
                    reader.readAsDataURL(file);
                } else {
                    saveBtnContainer.style.display = 'none';
                }
            });
        </script>

    </section>


@endsection
