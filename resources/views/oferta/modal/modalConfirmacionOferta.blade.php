<div id="modalConfirmacionOferta" class="modal" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">      
        <div class="modal-header">
          <h5 class="modal-title">Confirmar</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">        
          <h3>¿Esta seguro que quiere eliminar la oferta?</h3>    
        </div>
        <div class="modal-footer">
          <input type="hidden" name="id" id="idOfertaModalConfirmacion" value="">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
          <button type="button" onclick="confirmarEliminacionOferta()" class="btn btn-danger">Eliminar</button>
        </div>
    </div>
  </div>
</div>