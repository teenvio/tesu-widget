<input type="hidden" name="action" value="tesu_groups_save_ajax" />
<input type="hidden" name="security" value="__#security#__" />

	<p>__#texto grupos#__</p>
	<p>__#destino grupos#__</p>

	<br>
	<span id="tesu_msn_general" class="errorMSN"></span>
	<input id="tesu_type_group" type="hidden" name="type_group" value="none">
	<dl class="accordion columna">
        <dt><h4 style="margin:0px;"><a id="existinggroup" href="">__#grupo existente#__</a></h4></dt>
        <dd id="tesu_groupList">
            <span>__#selecciona grupo#__</span>
			<div class="controls">
				<select id='tesu_select_groupList' name="groupList" class="">
	                <option value="-1">[__#seleccione#__]</option>
	                __#opciones grupos#__
                </select>
				<span id="tesu_msn_groupList" class="errorMSN"></span>
			</div>
        </dd>
    
        <dt><h4 style="margin:0px;"><a id="newgroup" href="">__#grupo nuevo#__</a></h4></dt>
        <dd id="tesu_new_name" >
			<span >__#nombre#__</span>
			<div class="controls">
			    <input id="tesu_string_new_name" type="text" name="new_name" value="" title="Nombre">
				<span id="tesu_msn_new_name" class="errorMSN"></span>
			</div>	
						
			<p style="margin-bottom:0px;">__#descripcion#__</p>
			<div class="controls">
				<textarea id="tesu_string_new_description" name="new_description" class="text_area_peque" title="__#descripcion#__" cols="50" rows="10"></textarea>
				<span id="tesu_msn_new_description" class="errorMSN"></span>
			</div> 
        </dd>
    </dl>
<div style="clear:both;">
    <h6>* __#campo obligatorio#__</h6>
    
    <a id="submit_group" class="g1-button" style="display:none;">__#guardar#__</a>
</div>
