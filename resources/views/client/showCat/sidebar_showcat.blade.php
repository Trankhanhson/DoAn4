@foreach ($Categories as $item)
    <ul class="sidebar-list">
        @if ($item->CatID == $catId)
            <li class="sidebar-item_heading active"><a href="{{ route('client.showCat',$item->CatID)  }}">{{ $item->Name }}</a></li>
        @else
            <li class="sidebar-item_heading"><a href="{{ route('client.showCat',$item->CatID)  }}">{{ $item->Name }}</a></li>
        @endif
        @foreach ($item->ProductCats as $procat)
            <li><a class="sidebar_link" href="{{ route('client.showProCat',$procat->ProCatId ) }}">{{ $procat->Name }}</a></li>
        @endforeach
    </ul>   
@endforeach
