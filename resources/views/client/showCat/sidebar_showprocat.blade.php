@foreach ($model as $item)
    <ul class="sidebar-list">
        <li class="sidebar-item_heading"><a href="/ShowCat/ShowCat/{{ $item->CatID }}">{{ $item->Name }}</a></li>
        @foreach ($item->ProductCats as $procat)
            @if ($procat->ProCatId == $proCatId)
                <li><a class="sidebar_link active" href="/ShowCat/ShowProCat/{{ $procat->ProCatId }}">{{ $procat->Name }}</a></li>
            @else
                <li><a class="sidebar_link" href="/ShowCat/ShowProCat/{{ $procat->ProCatId }}">{{ $procat->Name }}</a></li>
            @endif
        @endforeach
    </ul>
@endforeach
