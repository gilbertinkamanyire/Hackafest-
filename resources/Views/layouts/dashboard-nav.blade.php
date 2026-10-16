<nav class="dashboard-nav" style="
    background: rgba(7, 10, 18, 0.92);
    border-bottom: 1px solid rgba(245, 158, 11, 0.22);
    box-shadow: 0 4px 30px rgba(0, 0, 0, 0.5);
    backdrop-filter: blur(24px);
    -webkit-backdrop-filter: blur(24px);
    position: sticky;
    top: 0;
    z-index: 100;
    font-family: 'Outfit', sans-serif;
    padding: 0.85rem 0;
">
    <div style="max-width: 1380px; margin: 0 auto; padding: 0 1.5rem; display: flex; justify-content: space-between; align-items: center; gap: 1.5rem;">
        <!-- Brand Crest -->
        <div style="display: flex; align-items: center; gap: 1rem;">
            <a href="{{ route('dashboard') }}" style="display: flex; align-items: center; gap: 0.75rem; text-decoration: none;">
                <div style="width: 38px; height: 38px; border-radius: 10px; background: linear-gradient(135deg, rgba(245, 158, 11, 0.25), rgba(180, 83, 9, 0.15)); border: 1px solid #fbbf24; display: flex; align-items: center; justify-content: center; box-shadow: 0 0 15px rgba(245, 158, 11, 0.3);">
                    <i class="ti ti-scale" style="font-size: 1.3rem; color: #fbbf24;"></i>
                </div>
                <div>
                    <span style="font-size: 1.25rem; font-weight: 800; font-family: 'Cinzel', serif; background: linear-gradient(to right, #ffffff, #fbbf24); -webkit-background-clip: text; -webkit-text-fill-color: transparent; letter-spacing: 0.05em;">
                        eWitnessVault
                    </span>
                    <div style="font-size: 0.65rem; color: #f59e0b; text-transform: uppercase; letter-spacing: 0.1em; font-weight: 700;">
                        Judicial Registry
                    </div>
                </div>
            </a>
        </div>
        
        <!-- Center Navigation Links -->
        <div style="display: flex; align-items: center; gap: 0.5rem;" class="hidden sm:flex">
            <!-- Dashboard -->
            <a href="{{ route('dashboard') }}" 
               style="display: flex; align-items: center; gap: 0.45rem; padding: 0.45rem 0.95rem; border-radius: 8px; font-size: 0.85rem; font-weight: 600; text-decoration: none; transition: all 0.25s ease;
               {{ request()->routeIs('dashboard') ? 'background: rgba(245, 158, 11, 0.15); color: #fbbf24; border: 1px solid rgba(245, 158, 11, 0.35); box-shadow: 0 0 15px rgba(245, 158, 11, 0.15);' : 'color: #94a3b8; border: 1px solid transparent;' }}"
               onmouseover="if(!this.classList.contains('active')){ this.style.color='#fbbf24'; this.style.background='rgba(245, 158, 11, 0.08)'; }"
               onmouseout="if(!this.classList.contains('active')){ this.style.color='#94a3b8'; this.style.background='transparent'; }">
                <i class="ti ti-layout-dashboard" style="font-size: 1.05rem;"></i>
                <span>Dashboard</span>
            </a>

            <!-- Evidence Registry -->
            <a href="{{ route('evidence.index') }}" 
               style="display: flex; align-items: center; gap: 0.45rem; padding: 0.45rem 0.95rem; border-radius: 8px; font-size: 0.85rem; font-weight: 600; text-decoration: none; transition: all 0.25s ease;
               {{ request()->routeIs('evidence.*') ? 'background: rgba(245, 158, 11, 0.15); color: #fbbf24; border: 1px solid rgba(245, 158, 11, 0.35); box-shadow: 0 0 15px rgba(245, 158, 11, 0.15);' : 'color: #94a3b8; border: 1px solid transparent;' }}"
               onmouseover="this.style.color='#fbbf24'; this.style.background='rgba(245, 158, 11, 0.08)';"
               onmouseout="if(!{{ request()->routeIs('evidence.*') ? 'true' : 'false' }}){ this.style.color='#94a3b8'; this.style.background='transparent'; }">
                <i class="ti ti-files" style="font-size: 1.05rem;"></i>
                <span>Evidence Vault</span>
            </a>

            <!-- Case Dockets (Lawyers, Judges, Admins) -->
            @if(Auth::check() && Auth::user()->hasAnyRole(['Lawyer', 'Judge', 'Admin']))
            <a href="{{ route('cases.index') }}" 
               style="display: flex; align-items: center; gap: 0.45rem; padding: 0.45rem 0.95rem; border-radius: 8px; font-size: 0.85rem; font-weight: 600; text-decoration: none; transition: all 0.25s ease;
               {{ request()->routeIs('cases.*') ? 'background: rgba(168, 85, 247, 0.15); color: #c084fc; border: 1px solid rgba(168, 85, 247, 0.4); box-shadow: 0 0 15px rgba(168, 85, 247, 0.15);' : 'color: #94a3b8; border: 1px solid transparent;' }}"
               onmouseover="this.style.color='#c084fc'; this.style.background='rgba(168, 85, 247, 0.08)';"
               onmouseout="if(!{{ request()->routeIs('cases.*') ? 'true' : 'false' }}){ this.style.color='#94a3b8'; this.style.background='transparent'; }">
                <i class="ti ti-briefcase" style="font-size: 1.05rem;"></i>
                <span>Case Dockets</span>
            </a>
            @endif

            <!-- Gemma AI Intelligence Hub (Judges & Lawyers Only) -->
            @if(Auth::check() && Auth::user()->hasAnyRole(['Judge', 'Lawyer', 'Admin']))
            <a href="{{ route('ai.index') }}" 
               style="display: flex; align-items: center; gap: 0.45rem; padding: 0.45rem 0.95rem; border-radius: 8px; font-size: 0.85rem; font-weight: 600; text-decoration: none; transition: all 0.25s ease;
               {{ request()->routeIs('ai.*') ? 'background: rgba(168, 85, 247, 0.18); color: #c084fc; border: 1px solid rgba(168, 85, 247, 0.4); box-shadow: 0 0 15px rgba(168, 85, 247, 0.2);' : 'color: #94a3b8; border: 1px solid transparent;' }}"
               onmouseover="this.style.color='#c084fc'; this.style.background='rgba(168, 85, 247, 0.08)';"
               onmouseout="if(!{{ request()->routeIs('ai.*') ? 'true' : 'false' }}){ this.style.color='#94a3b8'; this.style.background='transparent'; }">
                <i class="ti ti-sparkles" style="font-size: 1.05rem; color: #c084fc;"></i>
                <span>Gemma AI</span>
            </a>
            @endif

            <!-- Admin Console (if Admin) -->
            @if(Auth::check() && Auth::user()->hasRole('Admin'))
            <a href="{{ route('admin.dashboard') }}" 
               style="display: flex; align-items: center; gap: 0.45rem; padding: 0.45rem 0.95rem; border-radius: 8px; font-size: 0.85rem; font-weight: 600; text-decoration: none; transition: all 0.25s ease;
               {{ request()->routeIs('admin.*') ? 'background: rgba(245, 158, 11, 0.18); color: #fbbf24; border: 1px solid rgba(245, 158, 11, 0.4);' : 'color: #94a3b8; border: 1px solid transparent;' }}"
               onmouseover="this.style.color='#fbbf24'; this.style.background='rgba(245, 158, 11, 0.08)';"
               onmouseout="if(!{{ request()->routeIs('admin.*') ? 'true' : 'false' }}){ this.style.color='#94a3b8'; this.style.background='transparent'; }">
                <i class="ti ti-crown" style="font-size: 1.05rem; color: #fbbf24;"></i>
                <span>Judicial Admin</span>
            </a>
            @endif
        </div>
        
        <!-- Right Utilities & Profile -->
        <div style="display: flex; align-items: center; gap: 1rem;">
            <!-- Quick Upload CTA (Witnesses Only) -->
            @if(Auth::check() && Auth::user()->hasRole('Witness'))
            <a href="{{ route('upload') }}" 
               style="display: inline-flex; align-items: center; gap: 0.45rem; padding: 0.45rem 1rem; border-radius: 8px; font-size: 0.825rem; font-weight: 700; color: #0b0f19; background: linear-gradient(135deg, #f59e0b, #fbbf24); border: 1px solid #fbbf24; text-decoration: none; box-shadow: 0 2px 12px rgba(245, 158, 11, 0.35); transition: all 0.2s ease;"
               onmouseover="this.style.transform='translateY(-1px)'; this.style.boxShadow='0 4px 20px rgba(245, 158, 11, 0.5)';"
               onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 2px 12px rgba(245, 158, 11, 0.35)';">
                <i class="ti ti-camera" style="font-size: 0.95rem;"></i>
                <span>Capture Evidence</span>
            </a>
            @endif

            <!-- User Menu -->
            <div style="position: relative;">
                <button onclick="toggleUserDropdown()" style="display: flex; align-items: center; gap: 0.65rem; padding: 0.35rem 0.75rem 0.35rem 0.35rem; background: rgba(16, 23, 38, 0.75); border: 1px solid rgba(245, 158, 11, 0.25); border-radius: 50px; cursor: pointer; transition: all 0.2s ease;"
                        onmouseover="this.style.borderColor='rgba(251, 191, 36, 0.5)'; this.style.background='rgba(20, 28, 48, 0.9)';"
                        onmouseout="this.style.borderColor='rgba(245, 158, 11, 0.25)'; this.style.background='rgba(16, 23, 38, 0.75)';"
                        id="userNavBtn">
                    <div style="width: 32px; height: 32px; border-radius: 50%; background: linear-gradient(135deg, #f59e0b, #b45309); border: 1px solid #fbbf24; display: flex; align-items: center; justify-content: center; font-size: 0.75rem; font-weight: 800; color: white;">
                        {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
                    </div>
                    <div style="text-align: left; line-height: 1.2;">
                        <span style="font-size: 0.8125rem; font-weight: 700; color: #f1f5f9; display: block; max-width: 110px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                            {{ Auth::user()->name }}
                        </span>
                        <span style="font-size: 0.65rem; color: #fbbf24; font-weight: 600; text-transform: uppercase;">
                            @if(Auth::user()->hasRole('Admin')) Admin @elseif(Auth::user()->hasRole('Judge')) Judge @elseif(Auth::user()->hasRole('Lawyer')) Lawyer @else Witness @endif
                        </span>
                    </div>
                    <i class="ti ti-chevron-down" style="font-size: 0.8rem; color: #94a3b8; margin-left: 0.25rem;"></i>
                </button>

                <!-- Dropdown Menu -->
                <div id="userNavDropdown" style="display: none; position: absolute; top: 100%; right: 0; margin-top: 0.65rem; width: 14.5rem; background: rgba(10, 15, 26, 0.98); backdrop-filter: blur(24px); border: 1.5px solid rgba(245, 158, 11, 0.3); border-radius: 14px; box-shadow: 0 15px 40px rgba(0, 0, 0, 0.7); z-index: 1000; overflow: hidden;">
                    <div style="padding: 0.85rem 1rem; border-bottom: 1px solid rgba(71, 85, 105, 0.25); background: rgba(245, 158, 11, 0.05);">
                        <div style="font-size: 0.85rem; font-weight: 700; color: #f1f5f9;">{{ Auth::user()->name }}</div>
                        <div style="font-size: 0.75rem; color: #94a3b8; word-break: break-all;">{{ Auth::user()->email }}</div>
                    </div>

                    <div style="padding: 0.4rem;">
                        <a href="{{ route('profile.edit') }}" style="display: flex; align-items: center; gap: 0.6rem; padding: 0.6rem 0.85rem; border-radius: 8px; font-size: 0.825rem; color: #cbd5e1; text-decoration: none; transition: all 0.2s;"
                           onmouseover="this.style.background='rgba(245, 158, 11, 0.12)'; this.style.color='#fbbf24';"
                           onmouseout="this.style.background='transparent'; this.style.color='#cbd5e1';">
                            <i class="ti ti-user" style="font-size: 1rem; color: #fbbf24;"></i>
                            <span>Profile & Security</span>
                        </a>

                        <a href="{{ route('evidence.index') }}" style="display: flex; align-items: center; gap: 0.6rem; padding: 0.6rem 0.85rem; border-radius: 8px; font-size: 0.825rem; color: #cbd5e1; text-decoration: none; transition: all 0.2s;"
                           onmouseover="this.style.background='rgba(245, 158, 11, 0.12)'; this.style.color='#fbbf24';"
                           onmouseout="this.style.background='transparent'; this.style.color='#cbd5e1';">
                            <i class="ti ti-archive" style="font-size: 1rem; color: #fbbf24;"></i>
                            <span>My Evidence Files</span>
                        </a>

                        @if(Auth::check() && Auth::user()->hasAnyRole(['Lawyer', 'Judge', 'Admin']))
                        <a href="{{ route('cases.index') }}" style="display: flex; align-items: center; gap: 0.6rem; padding: 0.6rem 0.85rem; border-radius: 8px; font-size: 0.825rem; color: #cbd5e1; text-decoration: none; transition: all 0.2s;"
                           onmouseover="this.style.background='rgba(168, 85, 247, 0.12)'; this.style.color='#c084fc';"
                           onmouseout="this.style.background='transparent'; this.style.color='#cbd5e1';">
                            <i class="ti ti-briefcase" style="font-size: 1rem; color: #c084fc;"></i>
                            <span>Case Dockets</span>
                        </a>
                        @endif

                        @if(Auth::check() && Auth::user()->hasAnyRole(['Judge', 'Lawyer', 'Admin']))
                        <a href="{{ route('ai.index') }}" style="display: flex; align-items: center; gap: 0.6rem; padding: 0.6rem 0.85rem; border-radius: 8px; font-size: 0.825rem; color: #cbd5e1; text-decoration: none; transition: all 0.2s;"
                           onmouseover="this.style.background='rgba(168, 85, 247, 0.12)'; this.style.color='#c084fc';"
                           onmouseout="this.style.background='transparent'; this.style.color='#cbd5e1';">
                            <i class="ti ti-sparkles" style="font-size: 1rem; color: #c084fc;"></i>
                            <span>Gemma AI Hub</span>
                        </a>
                        @endif

                        <div style="height: 1px; background: rgba(71, 85, 105, 0.25); margin: 0.35rem 0;"></div>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" style="width: 100%; display: flex; align-items: center; gap: 0.6rem; padding: 0.6rem 0.85rem; border-radius: 8px; font-size: 0.825rem; color: #f87171; background: transparent; border: none; cursor: pointer; text-align: left; font-family: 'Outfit', sans-serif; transition: all 0.2s;"
                                    onmouseover="this.style.background='rgba(239, 68, 68, 0.12)';"
                                    onmouseout="this.style.background='transparent';">
                                <i class="ti ti-logout" style="font-size: 1rem;"></i>
                                <span>Sign Out of Vault</span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function toggleUserDropdown() {
            const dropdown = document.getElementById('userNavDropdown');
            if (dropdown) {
                dropdown.style.display = dropdown.style.display === 'none' || dropdown.style.display === '' ? 'block' : 'none';
            }
        }

        document.addEventListener('click', function(e) {
            const btn = document.getElementById('userNavBtn');
            const dropdown = document.getElementById('userNavDropdown');
            if (btn && dropdown && !btn.contains(e.target) && !dropdown.contains(e.target)) {
                dropdown.style.display = 'none';
            }
        });
    </script>
</nav>