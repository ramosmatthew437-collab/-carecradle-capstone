<div class="grid grid-cols-1 md:grid-cols-2 gap-6">

    <!-- First Name -->
    <div>
        <label class="block font-medium mb-2">First Name</label>
        <input type="text"
               name="first_name"
               value="{{ old('first_name', $midwife->first_name ?? '') }}"
               class="w-full border rounded-lg p-2"
               required>
    </div>

    <!-- Middle Name -->
    <div>
        <label class="block font-medium mb-2">Middle Name</label>
        <input type="text"
               name="middle_name"
               value="{{ old('middle_name', $midwife->middle_name ?? '') }}"
               class="w-full border rounded-lg p-2">
    </div>

    <!-- Last Name -->
    <div>
        <label class="block font-medium mb-2">Last Name</label>
        <input type="text"
               name="last_name"
               value="{{ old('last_name', $midwife->last_name ?? '') }}"
               class="w-full border rounded-lg p-2"
               required>
    </div>

    <!-- Contact Number -->
    <div>
        <label class="block font-medium mb-2">Contact Number</label>
        <input type="text"
               name="contact_number"
               value="{{ old('contact_number', $midwife->contact_number ?? '') }}"
               class="w-full border rounded-lg p-2">
    </div>

    <!-- Email -->
    <div class="md:col-span-2">
        <label class="block font-medium mb-2">Email</label>
        <input type="email"
               name="email"
               value="{{ old('email', $midwife->email ?? '') }}"
               class="w-full border rounded-lg p-2">
    </div>

</div>

<hr class="my-8">

<div class="grid grid-cols-1 md:grid-cols-2 gap-6">

    <!-- Username -->
    <div>
        <label class="block font-medium mb-2">Username</label>
        <input type="text"
               name="username"
               value="{{ old('username', $midwife->username ?? '') }}"
               class="w-full border rounded-lg p-2"
               required>
    </div>

    @if(!isset($midwife))

        <!-- Password -->
        <div>
            <label class="block font-medium mb-2">Password</label>
            <input type="password"
                   name="password"
                   class="w-full border rounded-lg p-2"
                   required>
        </div>

        <!-- Confirm Password -->
        <div>
            <label class="block font-medium mb-2">Confirm Password</label>
            <input type="password"
                   name="password_confirmation"
                   class="w-full border rounded-lg p-2"
                   required>
        </div>

    @endif

</div>