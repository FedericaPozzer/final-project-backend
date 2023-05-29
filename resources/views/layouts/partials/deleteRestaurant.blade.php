@if (auth()->user()->restaurant)
<div class="modal fade" id="delete-modal-restaurant" tabindex="-1" aria-labelledby="delete-modal-label"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-4 text-dark" id="delete-modal-label">Conferma eliminazione</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body text-start fs-3 fw-bold text-dark">
          Sei sicuro di voler eliminare il ristorante {{auth()->user()->restaurant->name}}<br>
          L'operazione non è reversibile.
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-info border fw-bold text-light" data-bs-dismiss="modal">Annulla</button>

          <form action="{{ route('restaurants.destroy', auth()->user()->restaurant) }}" method="POST" class="">
            @method('DELETE')
            @csrf

            <button type="submit" class="btn btn-danger border fw-bold">Elimina</button>
          </form>
        </div>
      </div>
    </div>
  </div>
  @endif