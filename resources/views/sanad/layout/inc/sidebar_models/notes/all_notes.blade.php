@foreach ($notes as $note)
    <div class="card ribbon mb-2">
        <div class="option-2 bg-primary position-absolute"></div>
        <div class="card-body">
            <span class="text-muted">{{ date('d M Y', strtotime($note->date)) }}</span>
            <p class="lead">{{ $note->title }}</p>
            <span>{{ $note->note }}</span>
        </div>
        <div class="card-footer pt-0 border-0">
            <a class="btn btn-sm btn-outline-secondary" href="#"><i class="fa fa-star favourite-note"></i></a>
            <a class="btn btn-sm btn-outline-secondary deleteButton" href="#"
                delete-route="{{ route('notes.destroy', $note->id) }}"><i class="fa fa-trash favourite-note"></i></a>
            <a class="btn btn-sm btn-outline-secondary editButton" data-bs-toggle="modal" data-bs-target="#createModal"
                model-route="{{ route('notes.edit', $note->id) }}">
                <i class="fa fa-pencil"></i>
            </a>
        </div>
    </div>
@endforeach
