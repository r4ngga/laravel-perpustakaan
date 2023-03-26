<div class="col-lg-6 col-7">
    <h5 class="h5 d-inline-block pl-2 pb-4">{{$parsing['title']}}</h4>
    <nav aria-label="breadcrumb" class="d-none d-md-inline-block ">
        <ol class="breadcrumb breadcrumb-pipe breadcrumb-dark pt-1 pl-1 bg-white">
            <li class="breadcrumb-item"><i class="fas fa-home"></i></li>
            @foreach($parsing['list'] as $key => $data)
            <li class="breadcrumb-item @if($data['is_active']) active @endif"> <a @if($data['href'] != '') href="{{$data['href'] ?? ''}} @endif" @if($data['is_active']) style="font-weight: bolder; color: black;" @endif>{{$data['text'] ?? ''}}</a></li>
            @endforeach
        </ol>
    </nav>
</div>
