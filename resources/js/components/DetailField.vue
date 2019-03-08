<template>
    <panel-item :field="field">
        <template slot="value">
			<excerpt class="summernote-details" :content="field.value" :should-show="field.shouldShow" />
        </template>
    </panel-item>
</template>

<script>
export default {
    props: ['resource', 'resourceName', 'resourceId', 'field'],
}
</script>
