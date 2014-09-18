<ol class="breadcrumb">
@foreach($items as $item)
    <li><a href="{{$item->url}}">{{$item->title}}</a></li>
@endforeach
    <li class="active">{{$active->title}}</li>
</ol>