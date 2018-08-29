<style>
    tr.tableadv td,tr.tableadv th{
        padding:0px;
        width:250px;
    }
</style>

<input type="hidden" name="action" value="tesu_advanced_save_ajax" />
<input type="hidden" name="security" value="__#security#__" />
<p>__#texto_advanced#__</p>
<table class="form-table" style="width:auto;">
    <tbody>
        <tr>
            <th scope="row" colspan=2>__#txtfinalidad#__</th>
        </tr>
        <tr id='tesu_string_finalidad' >
            <td colspan=2>
                <textarea rows="4" cols="85" name='finalidad'>__#finalidad#__</textarea>
            </td>
        </tr>
        
        <tr id='tesu_string_polpriv' class="tableadv" >
            <th scope="row"><input name='labelpolpriv' type='text' size='30' value='__#txturlpoliticas#__' readonly> <a id="tooglepolpriv" class="dashicons dashicons-edit"> </a></th>
            <td>
                <input data-validation='required ' name='polpriv' size='40' type='text' placeholder='__#exurlpoliticas#__' value='__#urlpoliticas#__' />
            </td>
            <td id="tesu_msn_polpriv" class="errorMSN"></td>
        </tr>
        <tr id='tesu_string_conuso' class="tableadv">
            <th scope="row"><input name='labelconuso' type='text'size='30'  value='__#txturlcondiciones#__' readonly> <a id="toogleconuso" class="dashicons dashicons-edit"> </a></th>
            <td>
                <input data-validation=' ' name='conuso' size='40' type='text' placeholder='__#exurlconuso#__' value='__#urlconuso#__' />
            </td>
            <td id="tesu_msn_conuso" class="errorMSN"></td>
        </tr>
        <tr id='tesu_string_avisolegal' class="tableadv">
            <th scope="row"><input name='labelavisolegal' type='text' size='30' value='__#txturlavisolegal#__' readonly> <a id="toogleavisolegal" class="dashicons dashicons-edit"> </a></th>
            <td>
                <input data-validation=' ' name='avisolegal' size='40' type='text' placeholder='__#exurlavisolegal#__' value='__#urlavisolegal#__' />
            </td>
            <td id="tesu_msn_avisolegal" class="errorMSN"></td>
        </tr>
    </tbody>
</table>

<br>
<h6>* __#campo obligatorio#__</h6>
<input id="tesudata" class="g1-button" name="Submit" type="submit" value="__#guardar#__" />