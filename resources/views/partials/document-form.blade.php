<div class="tab-pane fade {{ $index === 0 ? 'show active' : '' }}"
     id="{{ $document['id'] }}-content"
     role="tabpanel"
     aria-labelledby="{{ $document['id'] }}-tab">

    <div class="section-header">
        <h4 class="text-blue-500 text-xl font-bold">{{ $document['name'] }}</h4>
        <p class="text-muted">{{ $document['description'] }}</p>
    </div>

    <div class="row mb-4">
        <div class="col-md-6">
            <div class="form-group">
                <label for="{{ $document['id'] }}_number">Numéro d'identification <span class="text-danger">*</span></label>
                <input type="text" class="form-control"
                       id="{{ $document['id'] }}_number"
                       name="documents[{{ $document['id'] }}][identify_number]"
                       placeholder="Ex: 12345678"
                       required>
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group">
                <label for="{{ $document['id'] }}_expiry">Date d'expiration <span class="text-danger">*</span></label>
                <input type="date" class="form-control"
                       id="{{ $document['id'] }}_expiry"
                       name="documents[{{ $document['id'] }}][expiry_date]"
                       required>
            </div>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-md-6 mb-3">
            <label for="{{ $document['id'] }}_front">Face avant <span class="text-danger">*</span></label>
            <input type="file"
                   name="documents[{{ $document['id'] }}][front_image]"
                   id="{{ $document['id'] }}_front"
                   class="form-control"
                   accept=".jpg,.jpeg,.png,.pdf"
                   required>
        </div>

        <div class="col-md-6 mb-3">
            <label for="{{ $document['id'] }}_back">Face arrière <span class="text-danger">*</span></label>
            <input type="file"
                   name="documents[{{ $document['id'] }}][back_image]"
                   id="{{ $document['id'] }}_back"
                   class="form-control"
                   accept=".jpg,.jpeg,.png,.pdf"
                   required>
        </div>
    </div>

    <div class="form-step-footer">
        @if (!$last)
        <button type="button" class="btn btn-primary next-tab-btn"
                data-next="{{ $needed_documents[$index + 1]['id'] }}-tab"
                disabled>
            Continuer <i class="fas fa-arrow-right ms-2"></i>
        </button>
        @else
        <button type="submit" class="btn btn-success" id="submit-all-btn">
            Terminer <i class="fas fa-check ms-2"></i>
        </button>
        @endif
    </div>
</div>
