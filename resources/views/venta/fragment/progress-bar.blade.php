<div class="progress-bar-wrapper">
	<div class="status-bar" style="width: 75%;">
		<!-- Estado Pago confirmado y orden de compra recibida -->
		@if ($venta->id_estado_venta == 3)
			<div class="current-status" style="width: 0%; transition: width 4500ms linear 0s;">
			</div>
		@endif
		<!-- Orden de compra confirmada -->
		@if ($venta->id_estado_venta == 4)
			<div class="current-status" style="width: 33.33%; transition: width 4500ms linear 0s;">
			</div>
		@endif
		<!-- Orden Lista para retirar -->
		@if ($venta->id_estado_venta == 5)
			<div class="current-status" style="width: 66.66%; transition: width 4500ms linear 0s;">
			</div>
		@endif
		<!-- Orden entregada -->
		@if ($venta->id_estado_venta == 6)
			<div class="current-status" style="width: 100%; transition: width 4500ms linear 0s;">
			</div>
		@endif
	</div>
	<ul class="progress-bar">
		<!-- Estado Pago confirmado y orden de compra recibida -->
		@if ($venta->id_estado_venta == 3)
			<li class="section visited current" style="width: 25%;">Solicitud Recibida</li>
		@elseif($venta->id_estado_venta == 4 || $venta->id_estado_venta == 5 || $venta->id_estado_venta == 6)
			<li class="section visited" style="width: 25%;">Solicitud Recibida</li>
		@else
			<li class="section" style="width: 25%;">Solicitud Recibida</li>
		@endif
		<!-- Orden de compra confirmada -->
		@if ($venta->id_estado_venta == 4)
			<li class="section visited current" style="width: 25%;">Orden Confirmada</li>
		@elseif($venta->id_estado_venta == 5 || $venta->id_estado_venta == 6)
			<li class="section visited" style="width: 25%;">Orden Confirmada</li>
		@else
			<li class="section" style="width: 25%;">Orden Confirmada</li>
		@endif
		<!-- Orden Lista para retirar -->
		@if ($venta->id_estado_venta == 5)
			<li class="section visited current" style="width: 25%;">Orden Lista para retirar</li>
		@elseif($venta->id_estado_venta == 6)
			<li class="section visited" style="width: 25%;">Orden Lista para retirar</li>
		@else
			<li class="section" style="width: 25%;">Orden Lista para retirar</li>
		@endif
		<!-- Orden entregada -->
		@if ($venta->id_estado_venta == 6)
			<li class="section visited current" style="width: 25%;">Orden entregada</li>
		@else
			<li class="section" style="width: 25%;">Orden entregada</li>
		@endif
	</ul>
</div>