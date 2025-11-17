{{-- filepath: resources/views/admin/products/edit.blade.php --}}
@extends('admin.layout')

@section('title', 'Edit Product')
@section('page-title', 'Edit Product')

@push('styles')
<style>
    .gallery-item {
        position: relative;
        display: inline-block;
        margin: 5px;
    }
    .gallery-item img {
        width: 100px;
        height: 100px;
        object-fit: cover;
        border-radius: 8px;
        border: 2px solid #dee2e6;
    }
    .remove-gallery-btn {
        position: absolute;
        top: -5px;
        right: -5px;
        width: 20px;
        height: 20px;
        border-radius: 50%;
        background: #dc3545;
        color: white;
        border: none;
        font-size: 12px;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .current-image {
        width: 200px;
        height: 200px;
        object-fit: cover;
        border-radius: 8px;
        border: 2px solid #dee2e6;
    }
    .info-badge {
        background: #e7f3ff;
        border: 1px solid #b3d9ff;
        border-radius: 8px;
        padding: 1rem;
        margin-bottom: 1rem;
    }

    /* CKEditor image styles */
    .ck-editor__editable img {
        max-width: 100%;
        height: auto;
        border-radius: 8px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }

    .ck-editor__editable .image-style-side {
        float: right;
        margin-left: 1em;
        max-width: 50%;
    }

    .ck-editor__editable .image-style-align-left {
        float: left;
        margin-right: 1em;
    }

    .ck-editor__editable .image-style-align-center {
        display: block;
        margin: 1em auto;
    }

    .ck-editor__editable .image-style-align-right {
        float: right;
        margin-left: 1em;
    }

    /* Word counter */
    #word-counter {
        text-align: right;
        margin-top: 5px;
        font-size: 12px;
        color: #6c757d;
    }
</style>
@endpush

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="mb-1">Edit Product</h4>
        <p class="text-muted mb-0">{{ $product->name }}</p>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-2"></i>Back to Products
        </a>
    </div>
</div>

<!-- Product Info Badge -->
<div class="info-badge">
    <div class="row">
        <div class="col-md-2">
            <strong>ID:</strong> #{{ $product->id }}
        </div>
        <div class="col-md-3">
            <strong>SKU:</strong> {{ $product->sku }}
        </div>
        <div class="col-md-3">
            <strong>Slug:</strong> {{ $product->slug }}
        </div>
        <div class="col-md-2">
            <strong>Stock:</strong> {{ $product->stock }}
        </div>
        <div class="col-md-2">
            <strong>Created:</strong> {{ $product->created_at->format('d/m/Y') }}
        </div>
    </div>
</div>

<form action="{{ route('admin.products.update', $product) }}" method="POST" enctype="multipart/form-data" id="productForm">
    @csrf
    @method('PUT')

    <div class="row">
        <!-- Main Content -->
        <div class="col-lg-8">
            <!-- Basic Information -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0"><i class="fas fa-info-circle me-2"></i>Basic Information</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label class="form-label">Product Name <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                                   value="{{ old('name', $product->name) }}" placeholder="Enter product name" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Current slug: <code>{{ $product->slug }}</code> (will update if name changes)</small>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">SKU</label>
                            <input type="text" name="sku" class="form-control @error('sku') is-invalid @enderror"
                                   value="{{ old('sku', $product->sku) }}" placeholder="Product SKU">
                            @error('sku')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Barcode</label>
                            <input type="text" name="barcode" class="form-control @error('barcode') is-invalid @enderror"
                                   value="{{ old('barcode', $product->barcode) }}" placeholder="Product barcode">
                            @error('barcode')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Short Description</label>
                        <textarea name="short_description" class="form-control @error('short_description') is-invalid @enderror"
                                  rows="3" placeholder="Brief product description">{{ old('short_description', $product->short_description) }}</textarea>
                        @error('short_description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Full Description <span class="text-danger">*</span></label>
                        <textarea name="description" id="short_description" class="form-control @error('description') is-invalid @enderror"
                                  rows="8" placeholder="Detailed product description" required>{{ old('description', $product->description) }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Pricing & Inventory -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0"><i class="fas fa-dollar-sign me-2"></i>Pricing & Inventory</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Price <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <input type="number" name="price" class="form-control @error('price') is-invalid @enderror"
                                       value="{{ old('price', $product->price) }}" placeholder="0.00" step="0.01" min="0" required>
                                <span class="input-group-text">đ</span>
                            </div>
                            @error('price')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Current: {{ number_format($product->price, 0) }}đ</small>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label class="form-label">Stock Quantity <span class="text-danger">*</span></label>
                            <input type="number" name="stock" class="form-control @error('stock') is-invalid @enderror"
                                   value="{{ old('stock', $product->stock) }}" min="0" required>
                            @error('stock')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Current stock: {{ $product->stock }}</small>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label class="form-label">Compare Price</label>
                            <div class="input-group">
                                <input type="number" name="compare_price" class="form-control @error('compare_price') is-invalid @enderror"
                                       value="{{ old('compare_price', $product->compare_price) }}" placeholder="0.00" step="0.01" min="0">
                                <span class="input-group-text">đ</span>
                            </div>
                            @error('compare_price')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Original price for discount display</small>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0"><i class="fas fa-images me-2"></i>Product Images</h5>
                </div>
                <div class="card-body">
                    <div class="mb-4">
                        <label class="form-label">Main Image</label>
                        @if($product->main_image_url)
                            <div class="mb-3">
                                <div class="d-flex align-items-start gap-3">
                                    <img src="{{ $product->main_image_url }}" width="200" height="200"
                                         alt="{{ $product->name }}"
                                         class="current-image">
                                    <div>
                                        <p class="mb-1"><strong>Current Image:</strong></p>
                                        <p class="text-muted small mb-2">{{ $product->main_image_url }}</p>
                                        <input type="file" name="image" class="form-control @error('image') is-invalid @enderror"
                                               accept="image/*">
                                        <small class="form-text text-muted">Leave empty to keep current image</small>
                                    </div>
                                </div>
                            </div>
                        @else
                            <input type="file" name="image" class="form-control @error('image') is-invalid @enderror"
                                   accept="image/*">
                            <small class="form-text text-muted">Upload main product image (JPG, PNG, WebP)</small>
                        @endif
                        @error('image')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Gallery Images -->
                    <div class="mb-3">
                        <label class="form-label">Gallery Images</label>

                        @if($product?->gallery_urls && count($product?->gallery_urls) > 0)
                            <div class="mb-3">
                                <p class="mb-2"><strong>Current Gallery:</strong></p>
                                <div id="current-gallery">
                                    @foreach($product->media as $index => $galleryImage)
                                        @if ($galleryImage->collection_name == 'gallery')
                                            <div class="gallery-item" data-image="{{ $galleryImage->id }}">
                                                <img width="100" height="100"
                                                     src="{{ $galleryImage->hasGeneratedConversion('gallery') ? $galleryImage->getUrl('gallery') : $galleryImage->getUrl() }}"
                                                     alt="Gallery {{ $index + 1 }}">
                                                <button type="button" class="remove-gallery-btn"
                                                        onclick="removeGalleryImage('{{ $galleryImage->id }}', this)">
                                                    ×
                                                </button>
                                                <input type="hidden" name="existing_gallery[]" value="{{ $galleryImage->id }}">
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                                <small class="text-muted d-block mb-2">Click × to remove images</small>
                            </div>
                        @endif

                        <input type="file" name="gallery[]" class="form-control @error('gallery') is-invalid @enderror"
                               accept="image/*" multiple>
                        <small class="form-text text-muted">Upload additional images (will be added to existing gallery)</small>
                        @error('gallery')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        @error('gallery.*')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- SEO Information -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0"><i class="fas fa-search me-2"></i>SEO Information</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label">Meta Title</label>
                        <input type="text" name="meta_title" class="form-control @error('meta_title') is-invalid @enderror"
                               value="{{ old('meta_title', $product->meta_title) }}" placeholder="SEO title">
                        @error('meta_title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Meta Description</label>
                        <textarea name="meta_description" class="form-control @error('meta_description') is-invalid @enderror"
                                  rows="3" placeholder="SEO description">{{ old('meta_description', $product->meta_description) }}</textarea>
                        @error('meta_description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Meta Keywords</label>
                        <input type="text" name="meta_keywords" class="form-control @error('meta_keywords') is-invalid @enderror"
                               value="{{ old('meta_keywords', $product->meta_keywords) }}" placeholder="keyword1, keyword2, keyword3">
                        @error('meta_keywords')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
               <!-- Technical Specifications -->
            <div class="card mb-4 technical-specs">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="fas fa-flask me-2"></i>Thông số kỹ thuật
                        <small class="text-light ms-2">(Tùy chọn - Thêm thông tin chi tiết về sản phẩm)</small>
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <!-- Nồng độ tinh dầu -->
                        <div class="col-md-6 mb-3">
                            <label class="form-label">
                                <i class="fas fa-tint me-1 text-primary"></i>Nồng độ tinh dầu
                            </label>
                            <input type="text" name="concentration" class="form-control @error('concentration') is-invalid @enderror"
                                   value="{{ old('concentration',$product->concentration) }}" placeholder="Ví dụ: EDP (15-20%)">

                            @error('concentration')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Tỷ lệ tinh dầu thơm trong sản phẩm</small>
                        </div>

                        <!-- Dung tích -->
                        <div class="col-md-6 mb-3">
                            <label class="form-label">
                                <i class="fas fa-flask me-1 text-info"></i>Dung tích
                            </label>
                            <div class="input-group">
                                <input type="number" name="volume_ml" class="form-control @error('volume_ml') is-invalid @enderror"
                                       value="{{ old('volume_ml',$product->volume_ml) }}" placeholder="50" min="1" max="1000">
                                <span class="input-group-text">ml</span>
                            </div>
                            @error('volume_ml')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Dung tích chai nước hoa (ml)</small>
                        </div>

                        <!-- Độ lưu hương và Độ tỏa hương -->
                        <div class="col-md-6 mb-3">
                            <label class="form-label">
                                <i class="fas fa-clock me-1 text-warning"></i>Độ lưu hương
                            </label>
                            <input type="text" name="longevity" class="form-control @error('longevity') is-invalid @enderror"
                                   value="{{ old('longevity',$product->longevity) }}" placeholder="Ví dụ: 8-10 giờ">

                            @error('longevity')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Thời gian mùi hương tồn tại trên da</small>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">
                                <i class="fas fa-wind me-1 text-secondary"></i>Độ tỏa hương
                            </label>
                            <input type="text" name="sillage" class="form-control @error('sillage') is-invalid @enderror"
                                   value="{{ old('sillage',$product->sillage) }}" placeholder="Ví dụ: Mạnh (Trong phạm vi 2-3m)">

                            @error('sillage')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Phạm vi tỏa mùi của nước hoa</small>
                        </div>


                        <!-- Thành phần chính -->
                        <div class="col-md-12 mb-3">
                            <label class="form-label">
                                <i class="fas fa-leaf me-1 text-success"></i>Thành phần chính
                            </label>
                            <textarea name="main_ingredients" class="form-control @error('main_ingredients') is-invalid @enderror"
                                      rows="4" placeholder="Ví dụ: Bergamot, Hoa hồng, Xạ hương, Vanilla, Sandalwood..."
                                      id="ingredients-textarea">{{ old('main_ingredients',$product->main_ingredients) }}</textarea>
                            @error('main_ingredients')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="col-lg-4 sticky-top">
            <div class="sticky-top" style="top: 20px;">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0"><i class="fas fa-cog me-2"></i>Publishing Options</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-select @error('status') is-invalid @enderror">
                            <option value="draft" {{ old('status', $product->status) == 'draft' ? 'selected' : '' }}>Draft</option>
                            <option value="active" {{ old('status', $product->status) == 'active' ? 'selected' : '' }}>Active</option>
                            <option value="inactive" {{ old('status', $product->status) == 'inactive' ? 'selected' : '' }}>Inactive</option>
                        </select>
                        @error('status')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="text-muted">
                            Current:
                            <span class="badge bg-{{ $product->status === 'active' ? 'success' : ($product->status === 'draft' ? 'warning' : 'secondary') }}">
                                {{ ucfirst($product->status) }}
                            </span>
                        </small>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Type</label>
                        <select name="type" class="form-select @error('type') is-invalid @enderror">
                            <option value="men" {{ old('type', $product->type) == 'men' ? 'selected' : '' }}>Men</option>
                            <option value="women" {{ old('type', $product->type) == 'women' ? 'selected' : '' }}>Women</option>
                            <option value="unisex" {{ old('type', $product->type) == 'unisex' ? 'selected' : '' }}>Unisex</option>
                        </select>
                        @error('type')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="text-muted">Current: {{ ucfirst($product->type) }}</small>
                    </div>

                     <div class="mb-3">
                        <label class="form-label">Mùi Hương</label>
                        <select name="scrent_id" class="form-select @error('scrent_id') is-invalid @enderror">
                            <option value="">Select Scent</option>
                            @foreach($scents as $scent)
                                <option value="{{ $scent->id }}" {{ old('scrent_id',$product->scrent_id) == $scent->id ? 'selected' : '' }}>
                                    {{ $scent->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('scrent_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <div class="form-check">
                            <input type="checkbox" name="is_featured" class="form-check-input"
                                   id="is_featured" value="1" {{ old('is_featured', $product->is_featured) ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_featured">
                                Featured Product
                            </label>
                        </div>
                        <small class="text-muted">
                            Currently:
                            @if($product->is_featured)
                                <span class="badge bg-warning text-dark">Featured</span>
                            @else
                                <span class="badge bg-secondary">Not Featured</span>
                            @endif
                        </small>
                    </div>
                </div>
            </div>
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0"><i class="fas fa-folder me-2"></i>Category & Organization</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label">Category <span class="text-danger">*</span></label>
                        <select name="category_id" class="form-select @error('category_id') is-invalid @enderror" required>
                            <option value="">Select Category</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="text-muted">
                            Current: <strong>{{ $product->category->name ?? 'No category' }}</strong>
                        </small>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-body d-grid gap-2">
                    <button type="submit" name="action" value="save" class="btn btn-success">
                        <i class="fas fa-save me-2"></i>Update Product
                    </button>
                    <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">
                        <i class="fas fa-times me-2"></i>Cancel
                    </a>
                    <hr class="my-2">
                    <button type="button" class="btn btn-outline-danger" onclick="deleteProduct()">
                        <i class="fas fa-trash me-2"></i>Delete Product
                    </button>
                </div>
            </div>
            </div>
        </div>
    </div>
</form>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title">Confirm Delete</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete product <strong>"{{ $product->name }}"</strong>?</p>
                <p class="text-danger mb-0">
                    <i class="fas fa-exclamation-triangle me-1"></i>
                    This action cannot be undone!
                </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <form action="{{ route('admin.products.destroy', $product) }}" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Delete Product</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')

<script src="{{ asset('js/tinymce/tinymce.min.js') }}"></script>
<script>
     tinymce.init({
        selector: '#short_description',
        height: 800,
        menubar: false,
        license_key: 'gpl',

        plugins: [
            'advlist', 'autolink', 'lists', 'link', 'image', 'charmap', 'preview',
            'anchor', 'searchreplace', 'visualblocks', 'code', 'fullscreen',
            'insertdatetime', 'media', 'table', 'help', 'wordcount', 'textcolor'
        ],

        // Thêm các nút màu vào toolbar
        toolbar: 'undo redo | blocks | bold italic underline strikethrough | forecolor backcolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | removeformat | image media link | table | code preview fullscreen | help',

        content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:14px }',
        base_url: '{{ asset("js/tinymce") }}',
        suffix: '.min',

        // Cấu hình màu sắc tùy chỉnh
        color_map: [
            "000000", "Black",
            "993300", "Burnt orange",
            "333300", "Dark olive",
            "003300", "Dark green",
            "003366", "Dark azure",
            "000080", "Navy Blue",
            "333399", "Indigo",
            "333333", "Very dark gray",
            "800000", "Maroon",
            "FF6600", "Orange",
            "808000", "Olive",
            "008000", "Green",
            "008080", "Teal",
            "0000FF", "Blue",
            "666699", "Grayish blue",
            "808080", "Gray",
            "FF0000", "Red",
            "FF9900", "Amber",
            "99CC00", "Yellow green",
            "339966", "Sea green",
            "33CCCC", "Turquoise",
            "3366FF", "Royal blue",
            "800080", "Purple",
            "999999", "Medium gray",
            "FF00FF", "Magenta",
            "FFCC00", "Gold",
            "FFFF00", "Yellow",
            "00FF00", "Lime",
            "00FFFF", "Aqua",
            "00CCFF", "Sky blue",
            "993366", "Red violet",
            "FFFFFF", "White",
            "FF99CC", "Pink",
            "FFCC99", "Peach",
            "FFFF99", "Light yellow",
            "CCFFCC", "Pale green",
            "CCFFFF", "Pale cyan",
            "99CCFF", "Light sky blue",
            "CC99FF", "Plum"
        ],

        // Hoặc sử dụng color palette đơn giản hơn
        color_cols: 8,

        // Cho phép màu tùy chỉnh
        custom_colors: true,

        images_upload_url: '{{ route("admin.tinymce.upload") }}',
        images_upload_handler: function (blobInfo, progress) {
            return new Promise(function(resolve, reject) {
                const xhr = new XMLHttpRequest();
                xhr.withCredentials = false;
                xhr.open('POST', '{{ route("admin.tinymce.upload") }}');

                xhr.setRequestHeader('X-CSRF-TOKEN', document.querySelector('meta[name="csrf-token"]').content);

                xhr.upload.onprogress = function (e) {
                    progress(e.loaded / e.total * 100);
                };

                xhr.onload = function() {
                    if (xhr.status === 403) {
                        reject({message: 'HTTP Error: ' + xhr.status, remove: true});
                        return;
                    }

                    if (xhr.status < 200 || xhr.status >= 300) {
                        reject('HTTP Error: ' + xhr.status);
                        return;
                    }

                    const json = JSON.parse(xhr.responseText);

                    if (!json || typeof json.location != 'string') {
                        reject('Invalid JSON: ' + xhr.responseText);
                        return;
                    }

                    resolve(json.location);
                };

                xhr.onerror = function () {
                    reject('Image upload failed due to a XHR Transport error. Code: ' + xhr.status);
                };

                const formData = new FormData();
                formData.append('file', blobInfo.blob(), blobInfo.filename());

                xhr.send(formData);
            });
        },
        image_advtab: true,
        image_title: true,
        automatic_uploads: true,
        file_picker_types: 'image',
        object_resizing: true,
        resize_img_proportional: true,
        table_default_attributes: {
            class: 'table table-striped table-bordered'
        },
        table_default_styles: {},
        link_assume_external_targets: true,
        target_list: [
            {title: 'New window', value: '_blank'},
            {title: 'Same window', value: '_self'}
        ],
        setup: function(editor) {
            editor.on('init', function() {
                console.log('TinyMCE Self-hosted đã khởi tạo thành công!');
                updateWordCount();
            });

            editor.on('input keyup', function() {
                updateWordCount();
            });
        }
    });

    function updateWordCount() {
        const editor = tinymce.get('short_description');
        if (editor) {
            const content = editor.getContent({format: 'text'});
            const wordCount = content.trim() === '' ? 0 : content.trim().split(/\s+/).length;

            let counter = document.getElementById('word-counter');
            if (!counter) {
                counter = document.createElement('div');
                counter.id = 'word-counter';
                counter.className = 'text-muted small mt-1';
                document.querySelector('#short_description').parentNode.appendChild(counter);
            }
            counter.textContent = `Số từ: ${wordCount}`;
        }
    }

      function removeGalleryImage(imageId, button) {
      const galleryItem = button.closest('.gallery-item');
            const hiddenInput = galleryItem.querySelector('input[name="existing_gallery[]"]');
            if (hiddenInput) {
                hiddenInput.remove();
            }
            galleryItem.style.opacity = '0.5';
            button.disabled = true;
            button.style.display = 'none';
    }

    function deleteProduct() {
        const modal = new bootstrap.Modal(document.getElementById('deleteModal'));
        modal.show();
    }
    function previewImage(input, previewId) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            let preview = document.getElementById(previewId);
            if (!preview) {
                preview = document.createElement('img');
                preview.id = previewId;
                preview.style.cssText = 'width: 150px; height: 150px; object-fit: cover; border-radius: 8px; margin-top: 10px; border: 2px solid #28a745;';
                input.parentNode.appendChild(preview);
            }
            preview.src = e.target.result;
        };
        reader.readAsDataURL(input.files[0]);
    }
}
document.querySelector('input[name="image"]').addEventListener('change', function(e) {
    previewImage(e.target, 'main-image-preview');
});

document.querySelector('input[name="gallery[]"]').addEventListener('change', function(e) {
    previewGallery(e.target, 'gallery-preview');
});

function previewGallery(input, previewId) {
    let preview = document.getElementById(previewId);
    if (preview) {
        preview.remove();
    }

    if (input.files && input.files.length > 0) {
        preview = document.createElement('div');
        preview.id = previewId;
        preview.style.cssText = 'display: flex; gap: 10px; flex-wrap: wrap; margin-top: 10px; padding: 10px; border: 2px dashed #28a745; border-radius: 8px;';

        const title = document.createElement('p');
        title.textContent = 'New Images to Upload:';
        title.style.cssText = 'width: 100%; margin: 0 0 10px 0; font-weight: bold; color: #28a745;';
        preview.appendChild(title);

        Array.from(input.files).forEach(file => {
            const reader = new FileReader();
            reader.onload = function(e) {
                const img = document.createElement('img');
                img.src = e.target.result;
                img.style.cssText = 'width: 80px; height: 80px; object-fit: cover; border-radius: 8px; border: 2px solid #28a745;';
                preview.appendChild(img);
            };
            reader.readAsDataURL(file);
        });

        input.parentNode.appendChild(preview);
    }
}
</script>
@endpush
