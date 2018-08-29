<div class="tesu-main">
	<form action="#" onsubmit="return false;" class="tesuForm">
		<div class="tesu-loading">
			<img class="tesu-loading-image" src="__#urlloading#__" alt="__#loading#__..." />
		</div>
	    __#fields#__
	    <div class="form-group">
	        <div class="col-sm-12">
			   <!-- <input name="tesu-con" class="required tesu-con" type="checkbox"><a href="__#url_polpriv#__" target="_blank"> __#politicas#__ </a>
			    <span style="__#hide_conuso#__"> __#ylas#__ <a href="__#url_conuso#__" target="_blank"> __#condiciones#__ </a> </span>-->
			</div>
		</div>
	    <div class="form-group">
	        <div class="col-sm-12">
		        <input type="hidden" name="action" value="tesu_ajax_save"/>
		    	<button type="submit" class="tesu-button" class="btn btn-large btn-success">Enviar</button>
		        <span class="credit-link" style="float:right;">__#tesu#__</span>
		    </div>
		</div>
	</form>
	<div class="tesu-msg">__#gracias#__</div>
</div>

<style>
.tesu-error{padding-top:5px;padding-bottom:5px;margin-bottom:5px;border: 2px solid red !important;}
.tesu-loading {
   width: 100%;
   height: 100%;
   top: 0;
   left: 0;
   position: absolute;
   display: block;
   opacity: 0.7;
   background-color: #c4c4c4;
   z-index: 99;
   text-align: center;
   cursor:wait;
}
.tesu-msg,.tesu-loading{display:none;}

.tesu-loading-image {
  position: absolute;
  top: 50%;
  left: 50%;
  z-index: 100;
}
.tesu-main{position:relative;}
</style>