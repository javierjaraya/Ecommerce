<div id="modalEditEspecificacion" class="modal" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">      
        <div class="modal-header">
          <h5 class="modal-title">Editar Especificación</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">        
          <div class="form-group">
            <label for="nombre">Nombre</label>
            <input type="text" class="form-control" id="nombreEspecificacionModal" name="nombre" placeholder="Nombre">
          </div>
          <div class="form-group">
          <label for="descripcion">Descripción</label>
          <input type="text" class="form-control" id="descripcionEspecificacionModal" name="descripcion" placeholder="Descripción">
          </div>     
        </div>
        <div class="modal-footer">
          <input type="hidden" name="id" id="idEspecificacionModal" value="">
          <input type="hidden" name="id_producto" id="id_productoEspecificacionModal" value="">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
          <button type="button" onclick="guardarCambiosEspecificacion()" class="btn btn-primary">Guardar cambios</button>
        </div>
    </div>
  </div>
</div>