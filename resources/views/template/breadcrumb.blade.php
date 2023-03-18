<div class="col-lg-6 col-7">
    <h4 class="h4 text-black d-inline-block mb-0">{{$parsing['title']}}</h4>
    <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
        <ol class="breadcrumb breadcrumb-pipe breadcrumb-dark">
            <li class="breadcrumb-item"><a href="#"><i class="fas fa-home"></i></a></li>
            @foreach($parsing['list'] as $key => $data)
            <li class="breadcrumb-item @if($data['is_active']) active @endif"> <a @if($data['href'] != '') href="{{$data['href'] ?? ''}} @endif" @if($data['is_active']) style="font-weight: bolder; color: black;" @endif>{{$data['text'] ?? ''}}</a></li>
            @endforeach
        </ol>
    </nav>
</div>
