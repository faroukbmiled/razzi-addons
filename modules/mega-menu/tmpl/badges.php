<# var itemId = data.data['menu-item-db-id']; #>
<div id="tamm-panel-badges" class="tamm-panel-badges tamm-panel">
	<p class="rz-tamm-panel-box-large mega-setting">
		<span class="setting-field setting-field-custom">
			<label>
				<?php esc_html_e( 'Text', 'razzi' ) ?><br>
				<input type="text" name="{{ taMegaMenu.getFieldName( 'badges_text', itemId ) }}"
                       value="{{ data.megaData.badges_text }}">
			</label>
		</span>
    </p>
	<p class="background-color">
        <label><?php esc_html_e( 'Background Color', 'razzi' ) ?></label><br>
        <input type="text" class="background-color-picker"
               name="{{ taMegaMenu.getFieldName( 'badges_bg_color', itemId ) }}"
               value="{{ data.megaData.badges_bg_color }}">
    </p>
	<p class="color">
        <label><?php esc_html_e( 'Color', 'razzi' ) ?></label><br>
        <input type="text" class="background-color-picker"
               name="{{ taMegaMenu.getFieldName( 'badges_color', itemId ) }}"
               value="{{ data.megaData.badges_color }}">
    </p>
</div>