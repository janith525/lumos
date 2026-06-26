@php
    // Expect: $mainImage (string), $gallery (array), $uniqueId (string, optional)
    $uniqueId = $uniqueId ?? 'imgThumb'.uniqid();
    $gallery = isset($gallery) && is_array($gallery) && count($gallery) ? $gallery : (isset($mainImage) ? [$mainImage] : []);
    $main = $mainImage ?? ($gallery[0] ?? '');
@endphp

<div class="product-img-card mb-4 mt-3" id="{{ $uniqueId }}-wrapper">
    <div class="main-image-wrapper mb-3">
        <img id="{{ $uniqueId }}-main" src="{{ $main }}" alt="Gallery image" class="img-fluid w-100 rounded-3" style="cursor:zoom-in;">
    </div>

    <div class="thumbnails d-flex gap-2 flex-wrap" id="{{ $uniqueId }}-thumbs">
        @foreach($gallery as $g)
            <div class="thumb" style="width:64px;flex:0 0 auto;cursor:pointer;">
                <img src="{{ $g }}" data-full="{{ $g }}" class="img-fluid rounded border" style="width:64px;height:64px;object-fit:cover;">
            </div>
        @endforeach
    </div>

    <script>
        (function(){
            document.addEventListener('DOMContentLoaded', function(){
                const mainImg = document.getElementById('{{ $uniqueId }}-main');
                const thumbs = document.getElementById('{{ $uniqueId }}-thumbs');
                if(!mainImg || !thumbs) return;

                // Highlight first thumb
                const thumbImgs = Array.from(thumbs.querySelectorAll('img'));
                function setActive(i){
                    thumbImgs.forEach((t, idx)=>{
                        t.classList.toggle('active-thumb', idx===i);
                        t.style.outline = idx===i ? '2px solid #0d6efd' : 'none';
                    });
                }

                thumbImgs.forEach((t, i)=>{
                    t.addEventListener('click', function(e){
                        const src = this.dataset.full || this.src;
                        mainImg.src = src;
                        setActive(i);
                    });
                });

                // Open fancy viewer when clicking main image (if available)
                mainImg.addEventListener('click', function(){
                    if(window.openFancyViewer) window.openFancyViewer(this.src);
                });

                // Initialize active
                if(thumbImgs.length) setActive(0);
            });
        })();
    </script>
</div>
