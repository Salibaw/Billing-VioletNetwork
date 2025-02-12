
@include('header')
@include('nav')

<div class="container">
    <h1>Profile</h1>

    @if(!$profile)
        <div class="alert alert-warning">
            Your profile seems incomplete. Please <button id="addDetailsBtn" class="btn btn-link p-0" data-bs-toggle="modal" data-bs-target="#profileModal">update your profile</button>.
        </div>
    @else
        <div class="row mb-3">
            <div class="col-md-6">
                <label class="form-label"><strong>Username:</strong> </label>
                <p>{{ $user->username }}</p>
            </div>
            <div class="col-md-6">
                <label class="form-label"><strong>First Name:</strong></label>
                <p>{{ $user->first_name }}</p>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-6">
                <label class="form-label"><strong>Email:</strong> </label>
                <p>{{ $user->email }}</p>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-6">
                <label class="form-label"><strong>Company Name:</strong></label>
                <p>{{ $profile->company_name }}</p>
            </div>
            <div class="col-md-6">
                <label class="form-label"><strong>Position:</strong></label>
                <p>{{ $profile->position }}</p>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-6">
                <label class="form-label"><strong>Phone Number:</strong></label>
                <p>{{ $profile->phone_number }}</p>
            </div>
            <div class="col-md-6">
                <label class="form-label"><strong>Location Address:</strong></label>
                <p>{{ $profile->location_address }}</p>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-6">
                <label class="form-label"><strong>Gender:</strong></label>
                <p>{{ ucfirst($profile->gender) }}</p>
            </div>
            @isset($profile->photo)
                <div class="col-md-6">
                    <label class="form-label"><strong>Photo:</strong></label>
                    <div>
                        <img src="{{ asset('storage/' . $profile->photo) }}" alt="Profile Photo" class="img-thumbnail mt-2" width="150">
                        <form id="deletePhotoForm" method="POST" action="{{ route('profile.photo.delete') }}" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm mt-2">Delete Photo</button>
                        </form>
                    </div>
                </div>
            @endisset
        </div>

        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#profileModal">Edit Profile</button>
    @endif

    <!-- Modal -->
    <div class="modal fade" id="profileModal" tabindex="-1" aria-labelledby="profileModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="profileModalLabel">Update Profile</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
                        @csrf

                        <div class="mb-3">
                            <label for="username" class="form-label">Username</label>
                            <input type="text" class="form-control" id="username" name="username" value="{{ old('username', $user->username) }}" readonly>
                        </div>

                        <div class="mb-3">
                            <label for="first_name" class="form-label">First Name</label>
                            <input type="text" class="form-control" id="first_name" name="first_name" value="{{ old('first_name', $user->first_name) }}">
                        </div>

                        <div class="mb-3">
                            <label for="company_name" class="form-label">Company Name</label>
                            <input type="text" class="form-control" id="company_name" name="company_name" value="{{ old('company_name', $profile->company_name ?? '') }}">
                        </div>

                        <div class="mb-3">
                            <label for="position" class="form-label">Position</label>
                            <input type="text" class="form-control" id="position" name="position" value="{{ old('position', $profile->position ?? '') }}">
                        </div>

                        <div class="mb-3">
                            <label for="phone_number" class="form-label">Phone Number</label>
                            <input type="text" class="form-control" id="phone_number" name="phone_number" value="{{ old('phone_number', $profile->phone_number ?? '') }}">
                        </div>

                        <div class="mb-3">
                            <label for="location_address" class="form-label">Location Address</label>
                            <input type="text" class="form-control" id="location_address" name="location_address" value="{{ old('location_address', $profile->location_address ?? '') }}">
                        </div>

                        <div class="mb-3">
                            <label for="gender" class="form-label">Gender</label>
                            <select class="form-control" id="gender" name="gender">
                                <option value="male" {{ old('gender', $profile->gender ?? '') == 'male' ? 'selected' : '' }}>Male</option>
                                <option value="female" {{ old('gender', $profile->gender ?? '') == 'female' ? 'selected' : '' }}>Female</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="photo" class="form-label">Photo</label>
                            <input type="file" class="form-control" id="photo" name="photo">
                            @isset($profile->photo)
                                <img src="{{ asset('storage/' . $profile->photo) }}" alt="Profile Photo" class="img-thumbnail mt-2" width="150">
                            @endisset
                        </div>

                        <button type="submit" class="btn btn-primary">Update Profile</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var profile = @json($profile);
        var addDetailsBtn = document.getElementById('addDetailsBtn');
        
        if (profile) {
            addDetailsBtn.style.display = 'none';
        } else {
            addDetailsBtn.style.display = 'inline';
        }
    });
</script>