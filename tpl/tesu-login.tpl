<input type="hidden" name="action" value="tesu_login_save_ajax" />
<input type="hidden" name="security" value="__#security#__" />
<p>__#texto_acceso#__</p>
<table class="form-table" style="width:auto;">
    <tbody>
        <tr id="tesu_string_user">
            <th scope="row">__#name#__*</th>
            <td>
                <input data-validation="required teenvio_user" name="user" size="40" placeholder="__#name#__" type="text" value="__#val_name#__">
            </td>
            <td id="tesu_msn_user"  class="errorMSN">
            </td>
        </tr>
        <tr id="tesu_string_pass">
            <th scope="row">__#pass#__ *</th>
            <td>
                <input data-validation="required" name="pass" size="40" placeholder="__#pass#__" type="password" value="__#val_pass#__">
            </td>
            <td  id="tesu_msn_pass"  class="errorMSN">
            </td>
        </tr>
        <tr>
            <td id="tesu_msn_general" colspan=2 class="errorMSN">
            </td>
        </tr>
    </tbody>
</table>