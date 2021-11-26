<div id="sidenav">
    <ul>
        <div class="user">
            <div class="users"><i class="fa fa-user"></i>
            </div>
            <div class="users-text">
                {{ auth()->user()->name }}

            </div>
        </div>

        <li>
            <a href="{{ route('dashboard') }}" class="fa fa-home">
            </a>
        </li>
        <li>
            @if (auth()->user()->level=="disposisi")
            <a href="{{ route('waka') }}" class=" fa fa-file"> </a>
            @elseif(auth()->user()->level=="kepsek")
            <a href="{{ route('kepsek') }}" class=" fa fa-file"></a>
            @else
            <a href="{{ route('masuk') }}" class=" fa fa-file"></a>
            @endif
        </li>
        <li>
            <a href="{{ route('disposisi') }}" class=" fa fa-paper-plane"></a>
        </li>
        <li>
            <a href="" class="fa fa-archive"></a>
        </li>

    </ul>

</div>
