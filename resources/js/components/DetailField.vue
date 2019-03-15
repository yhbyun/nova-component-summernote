<template>
    <panel-item :field="field">
        <template slot="value">
			<excerpt class="note-editable summernote-details" :content="field.value" :should-show="field.shouldShow" />
        </template>
    </panel-item>
</template>

<style lang="scss" src="../../css/css.scss"></style>
<style lang="scss" src="../../css/app.scss"></style>

<script>
export default {
    props: ['resource', 'resourceName', 'resourceId', 'field'],
}
</script>
