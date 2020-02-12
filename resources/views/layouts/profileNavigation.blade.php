<div class="row justify-content-center profile-navigation no-gutters">
    <div class="col text-center">
        <a href="{{ route('user.profile.show', ['username' => $user->username]) }}"><div class="profile-navigation-link">View Profile</div></a>
    </div>
    <div class="col text-center">
        <a href="{{ route('user.profile.setup.show', ['username' => $user->username]) }}"><div class="profile-navigation-link">Profile Setup</div></a>
    </div>
    <div class="col text-center">
        <a href="{{ route('user.profile.password.show', ['username' => $user->username]) }}"><div class="profile-navigation-link">Change Password</div></a>
    </div>
</div>