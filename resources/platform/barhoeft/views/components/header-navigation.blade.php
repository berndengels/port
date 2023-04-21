<div class="w-100">
    <div class="float-start">
        <ul class="top-menu">
            @if(!isset($currentRoutes['route']) && isset($currentRoutes['items']) && count($currentRoutes['items']) > 0)
                @foreach($currentRoutes['items'] as $item)
                    @if(!isset($item['permissions']) || ( isset($item['permissions'])))
                        <li title="{{ $item['title'] }}"
                            class="ms-2 @if($item['help'])ps-1 pe-0 @endif align-middle @if($item['hide_on_mobile']) d-none d-md-inline-block @endif
                @if($currentRoute === $item['route'] || (isset($subRoutes[$item['route']]) && $subRoutes[$currentTopRoute]->contains($currentRoute)))
                    active
                @endif">
                            <a class="" href="{{ route($item['route']) }}">
                                @if($item['icon'])
                                    <i class="{{ $item['icon'] }}"></i>
                                    <span class="d-none d-md-inline-block">{{ $item['text'] }}</span>
                                @else
                                    <span>{{ $item['text'] }}</span>
                                @endif
                                @if($item['help'])
                                    <i class="far fa-circle-question me-1 help text-warning" data-help="{{ $item['help'] }}"></i>
                                @endif
                            </a>
                        </li>
                    @endif
                @endforeach
            @endif
        </ul>
    </div>
    <div class="float-end mt-3">
        <x-form method="post" class="hidden md:inline-block" name="frmLogout" action="{{ route($guard . '.logout') }}">
            @csrf
            <span class="d-none d-md-inline-block">{{ auth($guard)->user()->name }}</span>
            <x-form-submit inline class="btn btn-sm btn-primary" icon="fas fa-sign-out-alt" title="logout">
                <span class="d-none d-md-inline-block">Logout</span>
            </x-form-submit>
        </x-form>
    </div>
</div>
