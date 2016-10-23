    @extends('home1')

@section ('sidebar')

    @foreach($tabs as $tab)
          <li>
                    <a href="#" title="Elements">
                        <i class="glyph-icon icon-linecons-diamond"></i>
                        <span>{{ $tab['name'] }}</span>
                    </a>
                    @foreach($menu as $item)
                   @if( $tab['id']  == $item['tab_id'])
                    <div class="sidebar-submenu">
                      <ul>
                            <li><a href="{{$item['link']}}" title="{{$item['title']}}"><span>{{$item['title']}}</span></a></li>
                    </ul>
                    </div>
                @endif 
                @endforeach

        </li>
      @endforeach
@endsection