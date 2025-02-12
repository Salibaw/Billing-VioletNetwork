
@include('header')
@include('nav')

<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Settings</h1>
        <a href="{{ route('profile') }}" class="btn btn-secondary">Back to Profile</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <!-- Settings form -->
    <form action="{{ route('update-settings') }}" method="POST" id="settingsForm">
        @csrf
    
        <!-- Email update field -->
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email" value="{{ Auth::user()->email }}" readonly 
                onclick="this.readOnly=false;" onblur="this.readOnly=true;">
        </div>
    
        <!-- Password update fields -->
        <div class="mb-3 position-relative">
            <label for="current_password" class="form-label">Current Password</label>
            <div class="input-group">
                <input type="password" class="form-control" id="current_password" name="current_password">
                <button type="button" class="btn btn-outline-secondary toggle-password">
                    <i class="fa fa-eye" aria-hidden="true"></i>
                </button>
            </div>
            <div class="invalid-feedback"></div>
        </div>
    
        <div class="mb-3 position-relative">
            <label for="new_password" class="form-label">New Password</label>
            <div class="input-group">
                <input type="password" class="form-control" id="new_password" name="new_password">
                <button type="button" class="btn btn-outline-secondary toggle-password">
                    <i class="fa fa-eye" aria-hidden="true"></i>
                </button>
            </div>
            <small class="text-muted">Must be at least 8 characters long and include at least one uppercase letter, one lowercase letter, one numeric digit, and one special character.</small>
            <div class="invalid-feedback"></div>
        </div>
    
        <div class="mb-3 position-relative">
            <label for="new_password_confirmation" class="form-label">Confirm New Password</label>
            <div class="input-group">
                <input type="password" class="form-control" id="new_password_confirmation" name="new_password_confirmation">
                <button type="button" class="btn btn-outline-secondary toggle-password">
                    <i class="fa fa-eye" aria-hidden="true"></i>
                </button>
            </div>
            <div class="invalid-feedback"></div>
        </div>
    
        <button type="submit" class="btn btn-primary">Update Settings</button>
    </form>
    
    
    <!-- Account deletion form -->
    <form action="{{ route('delete-account') }}" method="POST" class="mt-3">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-danger">Delete Account</button>
    </form>
</div>
<style>
    .input-group .form-control {
        border-right: 0;
    }
    .input-group .btn {
        border-left: 0;
    }
    .toggle-password {
        cursor: pointer;
    }
    .invalid-feedback {
        display: block;
    }
    .is-valid {
        border-color: #28a745 !important;
    }
</style>


<!-- Include jQuery and jQuery Validation plugin -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js"></script>
<!-- Include Font Awesome for the eye icon -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

<script>
$(document).ready(function() {
    // Email field toggle
    $('.toggle-email').click(function() {
        var input = $('#email');
        input.prop('readonly', !input.prop('readonly'));
        $(this).find('i').toggleClass('fa-pencil fa-times');
    });

    // Password visibility toggle
    $('.toggle-password').click(function() {
        var input = $(this).siblings('input');
        var icon = $(this).find('i');
        if (input.attr('type') === 'password') {
            input.attr('type', 'text');
            icon.removeClass('fa-eye').addClass('fa-eye-slash');
        } else {
            input.attr('type', 'password');
            icon.removeClass('fa-eye-slash').addClass('fa-eye');
        }
    });

    // Password validation
    $.validator.addMethod("passwordRequirements", function(value, element) {
        return this.optional(element) 
            || /[A-Z]/.test(value)    // has an uppercase letter
            && /[a-z]/.test(value)    // has a lowercase letter
            && /[0-9]/.test(value)    // has a digit
            && /[^A-Za-z0-9]/.test(value) // has a special character
            && value.length >= 8;     // is at least 8 characters long
    }, "Must be at least 8 characters long and include at least one uppercase letter, one lowercase letter, one numeric digit, and one special character.");

    $('#settingsForm').validate({
        rules: {
            current_password: {
                required: function(element) {
                    return $('#new_password').val() !== '' || $('#new_password_confirmation').val() !== '';
                },
                remote: {
                    url: "{{ route('check-password') }}",
                    type: "POST",
                    data: {
                        current_password: function() {
                            return $("#current_password").val();
                        },
                        _token: "{{ csrf_token() }}"
                    }
                }
            },
            new_password: {
                required: function(element) {
                    return $('#current_password').val() !== '';
                },
                passwordRequirements: true
            },
            new_password_confirmation: {
                required: function(element) {
                    return $('#new_password').val() !== '';
                },
                equalTo: "#new_password"
            }
        },
        messages: {
            current_password: {
                required: "Please enter your current password.",
                remote: "Your current password is incorrect."
            },
            new_password: {
                required: "Please enter a new password."
            },
            new_password_confirmation: {
                required: "Please confirm your new password.",
                equalTo: "Passwords do not match."
            }
        },
        errorPlacement: function(error, element) {
            error.appendTo(element.siblings('.invalid-feedback'));
        },
        highlight: function(element) {
            $(element).addClass('is-invalid').removeClass('is-valid');
        },
        unhighlight: function(element) {
            $(element).addClass('is-valid').removeClass('is-invalid');
        }
    });

    // AJAX request to validate current password
    $('#current_password').on('blur', function() {
        var currentPassword = $(this).val();
        var inputElement = $(this);
        if (currentPassword !== '') {
            $.ajax({
                url: "{{ route('check-password') }}",
                method: "POST",
                data: {
                    current_password: currentPassword,
                    _token: "{{ csrf_token() }}"
                },
                success: function(response) {
                    if (response.valid) {
                        inputElement.removeClass('is-invalid').addClass('is-valid');
                        inputElement.siblings('.invalid-feedback').html('');
                    } else {
                        inputElement.removeClass('is-valid').addClass('is-invalid');
                        inputElement.siblings('.invalid-feedback').html('Your current password is incorrect.');
                    }
                }
            });
        }
    });
});
</script>
