<style>

#wpcontent{padding:0px!important;}
#wpbody-content{display:flex;flex-direction:column;}

.error th,.error span,.errorMSN{color:red!important;}
.error input{border: 1px solid red!important;}

.tesu-head{order:1;}
.notice{order:2;}
.tesu-body{order:3;}

.tesu-header {
    background-color: #fff;
    border-top: 5px solid #387599;
    box-shadow: 0 0 3px rgba(0, 0, 0, 0.15);
    padding: 20px 5%;
}

.tesu-head-content {
    background: rgba(0, 0, 0, 0) url(__#logo_head#__) no-repeat scroll 0 0;
    height: 44px;
    width: 100%;
}


.tesu-head h1 {
    background: #387599 none repeat scroll 0 0;
    color: #fff;
    display: block;
    font-size: 43px;
    font-weight: 300;
    margin: 0;
    padding: 20px 5%;
}
#tesu_wait {
    position:fixed;
    top:0px;
    left:0px;
    width:100%;
    height:100%;
    background-color:#c4c4c4;
    opacity:0.9;
    z-index:10000;
    display:none;
}
#tesu_wait_logo{
    background: rgba(0, 0, 0, 0) url(__#logo_loading#__) no-repeat scroll 0 0;
    position: absolute;
    top: 50%;
    left: 50%;
    z-index: 1001;
    width: 31px;
    height: 31px;
}

        div.tesucaja{cursor:pointer;}
        div.tesucaja,div.tesucajagrande{
            text-align:center;
            float:left;
            margin-left:2%;
            max-width:80px;
        }
        div.tesucaja:first-of-type{margin-left:0px;}
        div.tesucajagrande, div.tesucaja:last-of-type{float:right;}
        div.tesucajagrande{max-width:400px;}
        div.tesucajagrande img{float:left;}
        
        
        div.tesucaja span{text-decoration:strong;}
        img.tesulogocaja{
            width:64px;
        }


        hr.tesuhr{
            border:         none;
            border-left:    1px solid hsla(200, 10%, 50%,100);
            height:         50vh;
            float:left;
            width:          1px;  
        }
        main,.btndiv {
          /*min-width: 500px;*/
          max-width: 800px;
          padding: 50px;
          margin: 0 auto;
          background: #fff;
        }
        
        section {
          display: none;
          padding: 20px 0 0;
          border-top: 1px solid #ddd;
        }
        
        input {
          /*display: none;*/
        }
        
        label {
          display: inline-block;
          margin: 0 0 -1px;
          padding: 15px 25px;
          font-weight: 600;
          text-align: center;
          color: #bbb;
          border: 1px solid transparent;
          background-color:#ddd;
          cursor:default;
        }
        
        button, a.g1-button, input.g1-button[type="submit"] {
            background: #387599 none repeat scroll 0 0;
            border: 1px solid #387599;
            border-radius: 4px;
            color: #fff;
            cursor: pointer;
            display: inline-block;
            font-size: 14px;
            margin-bottom: 4px;
            padding: 12px 28px;
            transition: background-color 0.175s ease-in-out 0s, border-color 0.175s ease-in-out 0s, color 0.175s ease-in-out 0s;
        }
        
        
        button.btn-ligth, a.btn-ligth, input.btn-ligth[type="submit"] {
            background: #e6e6e6 none repeat scroll 0 0;
            border: 1px solid #e6e6e6;
            color: #999999;
            display: inline-block;
            margin-bottom: 15px;
            text-align: center;
            width: auto;
            text-decoration: none;
        }
        
        button:hover, a.g1-button:hover, input.g1-button[type="submit"]:hover {
            background: #1d3c4e none repeat scroll 0 0;
            color: #fff;
        }
        
        input:checked + label {
          color: #555;
          border: 1px solid #ddd;
          border-top: 2px solid #387599;
          border-bottom: 1px solid #fff;
          background-color: white;
        }
        
        #content1{ display: block;}
        .icontab{display:none!important;}
    a.btn-danger{
        background: none repeat scroll 0 0 #d9534f;
        color: #ffffff;
        border-color: #d43f3a;
    }
    a.btn-danger:hover {
        background: none repeat scroll 0 0 #c9302c;
        color: #ffffff;
        border-color: #ac2925;
    }
    #tesu-icon-header, #tesu-main{
        padding-left:5%;
        position:relative;
        background-color:white;
    }
    #tesu-main{
        padding-bottom:30px;
        padding-right:30px;
    }
    #tesu-icon-header{
        padding-top:20px;
        padding-bottom:110px;
        padding-right:5%;
        margin-bottom:5px;
    }
    /** Acordeones**/
    .accordion {max-width:500px;/* margin: 50px;*/}
    .accordion dt{
        margin-bottom: 2px;
        border: 1px solid #e5e5e5;
        -webkit-border-radius: 4px;
        -moz-border-radius: 4px;
        border-radius: 4px; 
    }
    .accordion dt h2{margin: 0;}
    .accordion dt a{
        background: none repeat scroll 0 0 #F4F4F4;
        display: block;
        padding: 8px 15px;
        color: black;
        text-decoration: none;
    }
    .accordion dd {
        background-color: #fff;
        padding: 9px 15px;
    }

</style>	

<script>
    jQuery( function() {
        jQuery(".nav-tab").on('click',function(){show_wait();});
        jQuery(".nav-tesu").on('click',function(){
            show_wait();
            var href = jQuery(this).attr('tesuhref');
            window.location.href = href;
        });
    });

    function show_wait(){
        jQuery("#tesu_wait").fadeIn();
    }
    function hide_wait(){
        jQuery("#tesu_wait").fadeOut();
    }
</script>

<div id="tesu_wait"><div id="tesu_wait_logo"></div></div>


<div class="tesu-head">
	<div class="tesu-header">
		<div class="tesu-head-content"></div>
	</div>
	<h1>__#configuracion#__</h1>
</div>
 