<div class="wrap">
    <h1>Configuration de Qiota</h1>
    <form method="post" action="qiota_settings" novalidate="novalidate">
        <table class="form-table" role="presentation">
            <tbody>
                <tr>
                    <th scope="row">
                        <label for="qiotatoken"><?php echo __('Token', 'qiota') ?></label>
                    </th>
                    <td>
                        <input name="qiotatoken" type="text" id="qiotatoken" value="" class="regular-text" />
                    </td>
                </tr>
            </tbody>
            <tr>
                <th scope="row">
                    <label scope="row"><?php echo __('Mode', 'qiota') ?></label>
                </th>
                <td>
                    <fieldset>
                        <label>
                            <input type="radio" name="qiotamode" value="production" checked="checked" />
                            <span>Production Mode</span>
                        </label>
                        <br />
                        <label>
                            <input type="radio" name="qiotamode" value="test" />
                            <span>Test Mode</span>
                        </label>
                    </fieldset>
                </td>
            </tr>
        </table>
        <p class="submit">
            <input type="submit" name="submit" id="submit" class="button button-primary" value="<?php echo __('Save changes', 'qiota') ?>">
        </p>
    </form>
</div>