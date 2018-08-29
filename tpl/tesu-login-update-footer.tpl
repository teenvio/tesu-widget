<input class="g1-button" name="Submit" type="submit" value="__#actualizar#__" /> 
<div style="float:right;"><a class="g1-button btn-danger" id="tesu_clean">__#limpiar_cuenta#__</a></div>

<style>
    #boxes{
        position:fixed;
        top:0px;
        left:0px;
        z-index:100000;
    }

    #boxes .window {
      position:fixed;
      width:440px;
      height:200px;
      display:none;
      z-index:9999;
      padding:20px;
      background-color:white;
    }
    
    
    /* Customize your modal window here, you can add background image too */
    #boxes #dialog {
      /*
      width:375px; 
      height:203px;
      */
    }
    #mask-modal {
      position:absolute;
      z-index:9000;
      background-color:#000;
      display:none;
      opacity: 0.6;
    }
</style>

<div id="boxes">
	<!-- #customize your modal window here -->

	<div id="dialog" class="window">
	    <p>__#esto_limpiara_todos_los_campos#__</p>
	    <div style="position: absolute;bottom: 5px;width: 90%;">
            <a style="position:absolute;right:0px" class="g1-button btn-danger" id="tesu_btn_clean" href="?page=tesu_plugin&tab=clean">__#limpiar_cuenta#__</a>
            <a class="g1-button" id="tesu_btn_cancelar">__#cancelar#__</a>
        </div>
    </div>
    <div id="mask-modal"></div>
</div>