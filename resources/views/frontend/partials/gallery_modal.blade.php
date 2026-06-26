{{-- Review & Gallery Lightbox Modal --}}
<div class="modal fade review-lightbox-modal" id="reviewModal" tabindex="-1" aria-labelledby="reviewModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl position-relative">
        <div class="modal-content border-0 bg-white rounded-4 shadow-2xl position-relative">
            {{-- Post Navigation Arrows (Inside Content but positioned outside via CSS) --}}
            <button class="modal-nav-btn outer-prev-btn" id="modalPrev">
                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 18 9 12 15 6"></polyline></svg>
            </button>
            <button class="modal-nav-btn outer-next-btn" id="modalNext">
                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"></polyline></svg>
            </button>
            
            <button type="button" class="btn-close position-absolute top-0 end-0 m-3 z-3" data-bs-dismiss="modal" aria-label="Close"></button>
            <div class="modal-body p-0">
                <div class="row g-0 min-vh-50">
                    {{-- Text Content Column --}}
                    <div class="col-lg-5 d-flex flex-column border-end">
                        <div class="p-4 p-lg-5">
                            <div class="d-flex align-items-center mb-4">
                                <div class="avatar-circle me-3 bg-primary bg-opacity-10 text-primary d-flex align-items-center justify-content-center fw-bold fs-4" id="modalInitials">
                                    L
                                </div>
                                <div class="w-100">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <h5 class="mb-0 fw-bold" id="modalName">Customer Name</h5>
                                        <span class="badge rounded-pill px-3 py-2" id="modalTypeBadge">Type</span>
                                    </div>
                                    <div class="star-rating text-warning small mt-1" id="modalStars">
                                        {{-- Stars will be injected here --}}
                                    </div>
                                </div>
                            </div>
                            <div class="review-text mb-4">
                                <p class="lead text-dark fs-5 italic" id="modalReview">"Full review text goes here..."</p>
                            </div>
                            <div class="mt-auto pt-4 border-top">
                                <div class="d-flex align-items-center gap-2 text-primary fw-bold" id="modalVerified">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><path d="M12 22C6.477 22 2 17.523 2 12S6.477 2 12 2s10 4.477 10 10-4.477 10-10 10zm-1.172-6.903l6.062-6.062-1.414-1.414-4.648 4.648-2.121-2.121-1.414 1.414 3.535 3.535z"/></svg>
                                    <span>Verified Source</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- Image Gallery Column --}}
                    <div class="col-lg-7 bg-light bg-opacity-50">
                        <div class="p-4 p-lg-5 h-100">
                            <h6 class="text-uppercase fw-bold text-muted small mb-3 letter-spacing-1">Gallery</h6>
                            <div class="row g-3" id="modalThumbnails">
                                {{-- Thumbnails will be injected here --}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- FancyBox-style Full Screen Viewer Overlay --}}
<div class="fancy-viewer-overlay" id="fancyViewer">
    <button class="fancy-close-btn" id="fancyClose">&times;</button>
    <img src="" id="fancyImg" alt="Full Image">
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const reviewModal = document.getElementById('reviewModal');
    if (!reviewModal) return;

    const modalName = document.getElementById('modalName');
    const modalReview = document.getElementById('modalReview');
    const modalStars = document.getElementById('modalStars');
    const modalInitials = document.getElementById('modalInitials');
    const modalTypeBadge = document.getElementById('modalTypeBadge');
    const modalThumbnails = document.getElementById('modalThumbnails');
    const prevBtn = document.getElementById('modalPrev');
    const nextBtn = document.getElementById('modalNext');
    
    // Fancy Viewer
    const fancyViewer = document.getElementById('fancyViewer');
    const fancyImg = document.getElementById('fancyImg');
    const fancyClose = document.getElementById('fancyClose');
    
    let currentIndex = 0;
    let cards = [];
    
    // Initialize cards dynamically so it works on any page containing social-post-cards!
    function initGallery() {
        cards = Array.from(document.querySelectorAll('.social-post-card'));
        
        cards.forEach((card, index) => {
            // Remove previous event listeners if any (by replacing the node)
            const newCard = card.cloneNode(true);
            card.parentNode.replaceChild(newCard, card);
            
            newCard.addEventListener('click', () => {
                updateModal(index);
            });
        });
        
        // Re-query the updated nodes
        cards = Array.from(document.querySelectorAll('.social-post-card'));
    }
    
    function updateModal(index) {
        if (index < 0 || index >= cards.length) return;
        const card = cards[index];
        const data = card.dataset;
        const currentPostImages = JSON.parse(data.images);
        
        modalName.textContent = data.name || '';
        modalReview.textContent = data.type === 'review' ? `"${data.review}"` : (data.review || '');
        modalInitials.textContent = (data.name || 'L').charAt(0);
        
        // Type Badge
        modalTypeBadge.textContent = data.type === 'review' ? 'Customer Review' : 'Social Post';
        modalTypeBadge.className = data.type === 'review' ? 'badge rounded-pill px-3 py-2 bg-primary' : 'badge rounded-pill px-3 py-2 bg-dark';
        
        // Stars
        if (data.type === 'review' && data.stars) {
            modalStars.classList.remove('d-none');
            const starCount = parseInt(data.stars);
            let starsHtml = '';
            for(let i=0; i<5; i++) {
                starsHtml += `<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="${i < starCount ? 'currentColor' : 'none'}" stroke="currentColor" stroke-width="2" class="me-1"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>`;
            }
            modalStars.innerHTML = starsHtml;
        } else {
            modalStars.classList.add('d-none');
        }
        
        // Image Grid
        modalThumbnails.innerHTML = '';
        currentPostImages.forEach((img, i) => {
            const col = document.createElement('div');
            col.className = 'col-6 col-md-4';
            col.innerHTML = `
                <div class="gallery-thumb-card cursor-zoom-in" onclick="openFancyViewer('${img}')">
                    <img src="${img}" class="img-fluid rounded-3 shadow-sm w-100 object-fit-cover" style="aspect-ratio: 1/1;">
                    <div class="thumb-overlay d-flex align-items-center justify-content-center">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line><line x1="11" y1="8" x2="11" y2="14"></line><line x1="8" y1="11" x2="14" y2="11"></line></svg>
                    </div>
                </div>
            `;
            modalThumbnails.appendChild(col);
        });
        
        currentIndex = index;
    }

    // Fancy Viewer Functions
    window.openFancyViewer = function(imgSrc) {
        if (!fancyImg || !fancyViewer) return;
        fancyImg.src = imgSrc;
        fancyViewer.classList.add('active');
        document.body.style.overflow = 'hidden';
    }

    if (fancyClose) {
        fancyClose.onclick = () => {
            fancyViewer.classList.remove('active');
            document.body.style.overflow = '';
        }
    }

    if (fancyViewer) {
        fancyViewer.onclick = (e) => {
            if(e.target === fancyViewer) fancyClose.click();
        }
    }
    
    // Initialize gallery events
    initGallery();
    
    if (prevBtn) {
        prevBtn.addEventListener('click', (e) => {
            e.stopPropagation();
            let newIndex = currentIndex - 1;
            if(newIndex < 0) newIndex = cards.length - 1;
            updateModal(newIndex);
        });
    }
    
    if (nextBtn) {
        nextBtn.addEventListener('click', (e) => {
            e.stopPropagation();
            let newIndex = currentIndex + 1;
            if(newIndex >= cards.length) newIndex = 0;
            updateModal(newIndex);
        });
    }

    // Keyboard navigation
    document.addEventListener('keydown', (e) => {
        if (fancyViewer && fancyViewer.classList.contains('active')) {
            if (e.key === 'Escape') fancyClose.click();
            return;
        }

        if (!reviewModal.classList.contains('show')) return;
        
        if (e.key === 'ArrowLeft' && prevBtn) prevBtn.click();
        if (e.key === 'ArrowRight' && nextBtn) nextBtn.click();
    });
});
</script>
