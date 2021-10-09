<div
	class="lastudio-kit-settings-page lastudio-kit-settings-page__avaliable-addons"
>
	<div class="lastudio-kit-settings-page__avaliable-controls">
		<div class="cx-vui-title"><?php _e( 'Avaliable Widgets', 'lastudio-kit' ); ?></div>
		<div
			class="lastudio-kit-settings-page__avaliable-control"
			v-for="(option, index) in pageOptions.avaliable_widgets.options"
		>
			<cx-vui-switcher
				:key="index"
				:name="`avaliable-widget-${option.value}`"
				:label="option.label"
				:wrapper-css="[ 'equalwidth' ]"
				return-true="true"
				return-false="false"
				v-model="pageOptions.avaliable_widgets.value[option.value]"
			>
			</cx-vui-switcher>
		</div>
	</div>

	<div class="lastudio-kit-settings-page__avaliable-controls">
		<div class="cx-vui-title"><?php _e( 'Avaliable Extensions', 'lastudio-kit' ); ?></div>
		<div
			class="lastudio-kit-settings-page__avaliable-control"
			v-for="(option, index) in pageOptions.avaliable_extensions.options">
			<cx-vui-switcher
				:key="index"
				:name="`avaliable-extension-${option.value}`"
				:label="option.label"
				:wrapper-css="[ 'equalwidth' ]"
				return-true="true"
				return-false="false"
				v-model="pageOptions.avaliable_extensions.value[option.value]"
			>
			</cx-vui-switcher>
		</div>
	</div>
</div>

