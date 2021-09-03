@php($product_tags = \Modules\Customer\Entities\Product_tag::get())
<div class="sidebar-widget-body outer-top-xs">
    <div class="tag-list">
        @foreach($product_tags as $product_tag)
        @php($tagname = \Modules\Customer\Entities\Tag::find($product_tag->tag_id)->name)
        <a class="item" title="{{$tagname}}" href="products/tag/{{$product_tag->tag_id}}">{{$tagname}}</a>
        @endforeach
    </div>
</div>