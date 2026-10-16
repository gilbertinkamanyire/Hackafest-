<x-app-layout>
    <x-slot name="header">
        <div style="display: flex; align-items: center; gap: 0.75rem;">
            <i class="ti ti-user-cog" style="font-size: 1.5rem; background: linear-gradient(135deg, #f59e0b, #fbbf24); -webkit-background-clip: text; -webkit-text-fill-color: transparent;"></i>
            <h2 style="font-family: 'Cinzel', serif; font-size: 1.3rem; font-weight: 800; color: #f1f5f9; letter-spacing: 0.5px;">Officer Profile Credentials</h2>
        </div>
    </x-slot>

    <div style="padding: 2.5rem 1rem; font-family: 'Outfit', sans-serif;">
        <div style="max-width: 800px; margin: 0 auto; display: flex; flex-direction: column; gap: 2.5rem;">
            
            <!-- Profile Info Section -->
            <div style="background: rgba(12, 17, 29, 0.88); backdrop-filter: blur(20px); border: 1.5px solid rgba(245, 158, 11, 0.25); border-radius: 20px; box-shadow: 0 20px 50px rgba(0,0,0,0.5); overflow: hidden;">
                <div style="padding: 2rem 2.5rem;">
                    <div style="max-width: 100%;">
                        @include('profile.partials.update-profile-information-form')
                    </div>
                </div>
            </div>

            <!-- Password Update Section -->
            <div style="background: rgba(15, 23, 42, 0.7); backdrop-filter: blur(20px); border: 1px solid rgba(168, 85, 247, 0.15); border-radius: 20px; box-shadow: 0 20px 50px rgba(0,0,0,0.4); overflow: hidden;">
                <div style="padding: 2rem 2.5rem;">
                    <div style="max-width: 100%;">
                        @include('profile.partials.update-password-form')
                    </div>
                </div>
            </div>

            <!-- Account Deletion Section -->
            <div style="background: rgba(15, 23, 42, 0.7); backdrop-filter: blur(20px); border: 1px solid rgba(239, 68, 68, 0.15); border-radius: 20px; box-shadow: 0 20px 50px rgba(0,0,0,0.4); overflow: hidden;">
                <div style="padding: 2rem 2.5rem;">
                    <div style="max-width: 100%;">
                        @include('profile.partials.delete-user-form')
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
