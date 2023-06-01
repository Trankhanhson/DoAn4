
@foreach ($Categories as $item)
<li class="sub-menu__item">
    <a class="sub-menu__link" href="{{ route('client.showCat',$item->CatID) }}">{{ $item->Name }}</a>
    <div class="sub-menu__detail-wrap py-3 position-absolute top-100 start-0 end-0" style="box-shadow: 0px 1px 10px rgb(163, 163, 163);background-color: rgba(255,255,255,.95);">
        <div class="row">
            <div class="col-7">
                <ul class="sub-menu__detail">
                    @if ($item->ProductCats)
                        @foreach ($item->ProductCats as $proCat)
                        <li><a href="{{ route('client.showProCat',$proCat->ProCatId) }}" data-idProCat="{{ $proCat->ProCatId }}">{{ $proCat->Name }}</a></li>
        
                        @endforeach
                    @endif
                </ul>
            </div>
            <div class="col-5">
                <img width="100%" src="https://canifa.com/assets/images/female-1.png" alt="">
            </div>
        </div>
    </div>
</li> 
 @endforeach
