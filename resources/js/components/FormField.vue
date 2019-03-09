<template>
    <default-field :field="field" :errors="errors" :full-width-content="true">
        <template slot="field">
            <div @mouseover="setValue" @keyup="setValue" :class="[errorClasses, errorClasses.length ? 'border' : '']" @keydown.stop>
            <textarea
                :id="field.attribute"
                :dusk="field.attribute"
                v-model="value"
                v-bind="extraAttributes"
            />
            </div>

            <p v-if="hasError" class="my-2 text-danger">
                {{ firstError }}
            </p>
        </template>
    </default-field>
</template>

<script>
import { FormField, HandlesValidationErrors } from 'laravel-nova';

import "summernote/dist/summernote-lite";
import 'summernote/dist/summernote-lite.css';
import 'codemirror/lib/codemirror';
import 'codemirror/lib/codemirror.css';

export default {
    mixins: [FormField, HandlesValidationErrors],

    props: ['resourceName', 'resourceId', 'field'],

    methods: {
        /*
         * Set the initial, internal value for the field.
         */
        setInitialValue() {
          this.value = this.field.value || ''
        },

        /**
         * Fill the given FormData object with the field's internal value.
         */
        fill(formData) {
          this.switchHtmlCodeViewToNormalView();
          this.setValue();
          formData.append(this.field.attribute, this.value || '')
        },

        /**
         * Update the field's internal value.
         */
        setValue() {
          let vm = this;
          this.value = $(vm.$el).find('.note-editable').html();
        },

        switchHtmlCodeViewToNormalView() {
          try {
            $(this.$el).find('.btn-codeview.active').click();
          } catch(e) {
            // just ignore
          };
        },

    },

    mounted() {
        let vm = this;

        $(document).ready(function() {
          $(vm.$el).find('textarea').summernote();
        });
    },

}
</script>
