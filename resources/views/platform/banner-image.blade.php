<a class="w-100 d-flex flex-column platform-product-item p-1" href="{{$link}}">
    <div class="text-wrap">
        <h5>{{$banner_name}}</h5>
    </div>
    <div  style="height: 100px; width: 100px">
        <img class="img-fluid w-100 h-100" src="{{$image}}" alt="" class="img-fluid">
    </div>
</a>
<style>
    .platform-product-item{
        transition: .2s
    }
    .platform-product-item:hover{
        background: #f2f2f2;
    }
</style>