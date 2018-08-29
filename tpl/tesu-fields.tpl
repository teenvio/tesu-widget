<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<style>
    #camposdisponibles li, #destino li{
        border: 1px solid #ccc;
        border-radius: 4px;
        padding: 10px;
        margin-bottom: 10px;
        background: #fff;
        cursor:move;
    }
        
    li.obligatorio{
        background-color: #c4c4c4 !important;
    }
    div.columna{
        width:40%;
        float:left;
    }
    #camposdisponibles, #destino{
        height: 200px;
        overflow-y: scroll;
        padding: 10px;
        background-color: #FFFFFF;
        border-radius: 4px;
        border: 1px solid #CCCCCC;
        box-shadow: 0 1px 1px rgba(0, 0, 0, 0.075) inset;
        transition: border 0.2s linear 0s, box-shadow 0.2s 
    }
    #camposdisponibles .mandatory{display:none;}
    div.columna:last-child{
        margin-left:10%;
    }
</style>

<div style="overflow:auto;padding-top:20px;">
    <div>__#texto campos#__</div>
    <div class="doblecolumna">
        <div class="columna">
            <h2>__#campos disponibles#__</h2>
            <div id="camposdisponibles">
                <ul class="sortable">
                    __#camposdisponibles#__
                </ul>
            </div>
        </div>
        <div class="columna">
            <h2>__#campos del formulario#__</h2>
            <div id="destino">
                <ul id="sortable" class="sortable">
                    __#camposformulario#__
                </ul>
            </div>
        </div>
    </div>
    <div style=" clear: both;"></div>
    <div class="doblecolumna">
        
        
    </div>
    
</div>
<div style="float:none;">
        
        </br>
        <input type="hidden" name="action" value="tesu_field_save_ajax" />
        <input type="hidden" name="security" value="__#security#__" />
        <a id="tesu_submit_fields" class="g1-button">__#guardar#__</a>
        <input id="tesu_fields" name="tesu_fields" type="hidden" />
    </div>
    <div id="saved"></div>